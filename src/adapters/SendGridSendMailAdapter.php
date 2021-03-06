<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\adapters;

use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\interfaces\SendMailAdapterInterface;
use SendGrid;
use SendGrid\Mail\Mail;
use function getenv;

class SendGridSendMailAdapter implements SendMailAdapterInterface
{
    /** @var Mail */
    private $mail;
    /** @var SendGrid */
    private $sendGrid;
    /** @var Html2TextFactory */
    private $html2TextFactory;

    public function __construct(
        Mail $mail,
        SendGrid $sendGrid,
        Html2TextFactory $html2TextFactory
    ) {
        $this->mail             = $mail;
        $this->sendGrid         = $sendGrid;
        $this->html2TextFactory = $html2TextFactory;
    }

    public function send(EmailModelInterface $emailModel) : void
    {
        if (! $emailModel->isValid()) {
            throw new InvalidEmailModelException();
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->mail->setFrom(
            getenv('WEBMASTER_EMAIL_ADDRESS'),
            getenv('WEBMASTER_NAME')
        );

        if ($emailModel->fromEmail()) {
            $this->mail->setReplyTo(
                $emailModel->fromEmail(),
                $emailModel->fromName() ?: null
            );
        }

        $this->mail->addTo(
            $emailModel->toEmail(),
            $emailModel->toName() ?? null
        );

        $this->mail->setSubject($emailModel->subject());

        if (! $emailModel->messagePlainText()) {
            $emailModel->messagePlainText(
                $this->html2TextFactory->make($emailModel->messageHtml())
                    ->getText()
            );
        }

        $this->mail->addContent('text/plain', $emailModel->messagePlainText());

        if ($emailModel->messageHtml()) {
            $this->mail->addContent('text/html', $emailModel->messageHtml());
        }

        $this->sendGrid->send($this->mail);
    }
}
