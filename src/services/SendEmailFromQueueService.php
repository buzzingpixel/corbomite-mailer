<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer\services;

use buzzingpixel\corbomitemailer\interfaces\EmailApiInterface;
use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;

class SendEmailFromQueueService
{
    private $emailApi;

    public function __construct(EmailApiInterface $emailApi)
    {
        $this->emailApi = $emailApi;
    }

    /**
     * @param $context
     * @throws InvalidEmailModelException
     */
    public function __invoke($context)
    {
        $this->emailApi->sendEmail($this->emailApi->createEmailModel([
            'fromName' => $context['fromName'],
            'fromEmail' => $context['fromEmail'],
            'toName' => $context['toName'],
            'toEmail' => $context['toEmail'],
            'subject' => $context['subject'],
            'messagePlainText' => $context['messagePlainText'],
            'messageHtml' => $context['messageHtml'],
        ]));
    }
}
