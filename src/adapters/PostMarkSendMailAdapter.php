<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer\adapters;

use Postmark\PostmarkClient;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\interfaces\SendMailAdapterInterface;
use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;

class PostMarkSendMailAdapter implements SendMailAdapterInterface
{
    private $postMark;
    private $html2TextFactory;

    public function __construct(
        PostmarkClient $postMark,
        Html2TextFactory $html2TextFactory
    ) {
        $this->postMark = $postMark;
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

        $to = $emailModel->toEmail();

        if ($emailModel->toName()) {
            $to = $emailModel->toName() . ' <' . $to . '>';
        }

        $replyTo = null;

        if ($emailModel->fromEmail()) {
            $replyTo = $emailModel->fromName();
            if ($emailModel->fromName()) {
                $replyTo = $emailModel->fromName() . ' <' . $emailModel->fromEmail() . '>';
            }
        }

        $this->postMark->sendEmail(
            getenv('WEBMASTER_EMAIL_ADDRESS'),
            $to,
            $emailModel->subject(),
            $emailModel->messageHtml() ?: null,
            $emailModel->messagePlainText(),
            null,
            true,
            $replyTo,
            null,
            null,
            null,
            null,
            'HtmlAndText',
            null
        );
    }
}
