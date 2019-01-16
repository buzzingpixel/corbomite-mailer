<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer\adapters;

use Mailgun\Mailgun;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\interfaces\SendMailAdapterInterface;
use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;

class MailGunSendMailAdapter implements SendMailAdapterInterface
{
    private $mailgun;
    private $html2TextFactory;

    public function __construct(
        Mailgun $mailgun,
        Html2TextFactory $html2TextFactory
    ) {
        $this->mailgun = $mailgun;
        $this->html2TextFactory = $html2TextFactory;
    }

    public function send(EmailModelInterface $emailModel)
    {
        if (! $emailModel->isValid()) {
            throw new InvalidEmailModelException();
        }

        if (! $emailModel->messagePlainText()) {
            $emailModel->messagePlainText(
                $this->html2TextFactory->make($emailModel->messageHtml())
                    ->getText()
            );
        }

        $message = [
            'from' => getenv('WEBMASTER_NAME') . ' <' . getenv('WEBMASTER_EMAIL_ADDRESS') . '>',
            'to' => $emailModel->toEmail(),
            'subject' => $emailModel->subject(),
            'text' => $emailModel->messagePlainText(),
        ];

        if ($emailModel->fromEmail()) {
            $message['h:Reply-To'] = $emailModel->fromEmail();
            if ($emailModel->fromName()) {
                $message['h:Reply-To'] = $emailModel->fromName() . ' <' . $emailModel->fromEmail() . '>';
            }
        }

        if ($emailModel->messageHtml()) {
            $message['html'] = $emailModel->messageHtml();
        }

        try {
            $this->mailgun->messages()->send(getenv('MAILGUN_DOMAIN'), $message);
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
            die;
        }
    }
}
