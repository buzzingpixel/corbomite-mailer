<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\adapters;

use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\interfaces\SendMailAdapterInterface;
use Mandrill;
use function getenv;

class MandrillSendMailAdapter implements SendMailAdapterInterface
{
    /** @var Mandrill */
    private $mandrill;
    /** @var Html2TextFactory */
    private $html2TextFactory;

    public function __construct(
        Mandrill $mandrill,
        Html2TextFactory $html2TextFactory
    ) {
        $this->mandrill         = $mandrill;
        $this->html2TextFactory = $html2TextFactory;
    }

    public function send(EmailModelInterface $emailModel) : void
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
            'text' => $emailModel->messagePlainText(),
            'subject' => $emailModel->subject(),
            'from_email' => getenv('WEBMASTER_EMAIL_ADDRESS'),
            'from_name' => getenv('WEBMASTER_NAME'),
            'to' => [[
                'email' => $emailModel->toEmail(),
                'name' => $emailModel->toName() ?: $emailModel->toEmail(),
                'type' => 'to',
            ],
            ],
            'important' => false,
            'track_opens' => true,
            'track_clicks' => true,
            'auto_text' => false,
            'auto_html' => false,
            'inline_css' => false,
            'url_strip_qs' => false,
            'preserve_recipients' => true,
            'view_content_link' => true,
            'bcc_address' => null,
            'tracking_domain' => null,
            'signing_domain' => null,
            'return_path_domain' => null,
        ];

        if ($emailModel->messageHtml()) {
            $message['html'] = $emailModel->messageHtml();
        }

        if ($emailModel->fromEmail()) {
            $message['headers'] = [
                'Reply-To' => $emailModel->fromEmail(),
            ];
        }

        /** @noinspection PhpParamsInspection */
        $this->mandrill->messages->send($message);
    }
}
