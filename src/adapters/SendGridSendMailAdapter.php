<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer\adapters;

use SendGrid;
use SendGrid\Mail\Mail;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\interfaces\SendMailAdapterInterface;
use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;

class SendGridSendMailAdapter implements SendMailAdapterInterface
{
    private $mail;
    private $sendGrid;
    private $html2TextFactory;

    public function __construct(
        Mail $mail,
        SendGrid $sendGrid,
        Html2TextFactory $html2TextFactory
    ) {
        $this->mail = $mail;
        $this->sendGrid = $sendGrid;
        $this->html2TextFactory = $html2TextFactory;
    }

    public function send(EmailModelInterface $emailModel)
    {
        if (! $emailModel->isValid()) {
            throw new InvalidEmailModelException();
        }

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

        if (! $emailModel->messagePlainText()) {
            $emailModel->messagePlainText(
                $this->html2TextFactory->make($emailModel->messageHtml())
                    ->getText()
            );
        }

        $this->mail->setSubject($emailModel->subject());

        $this->mail->addContent('text/plain', $emailModel->messagePlainText());

        if ($emailModel->messageHtml()) {
            $this->mail->addContent('text/html', $emailModel->messageHtml());
        }

        $this->sendGrid->send($this->mail);
        // $response = $this->sendGrid->send($this->mail);
        // print $response->statusCode() . "\n";
        // print_r($response->headers());
        // print $response->body() . "\n";
    }
}
