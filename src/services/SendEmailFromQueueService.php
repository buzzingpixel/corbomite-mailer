<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\services;

use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;
use buzzingpixel\corbomitemailer\interfaces\EmailApiInterface;

class SendEmailFromQueueService
{
    /** @var EmailApiInterface */
    private $emailApi;

    public function __construct(EmailApiInterface $emailApi)
    {
        $this->emailApi = $emailApi;
    }

    /**
     * @param mixed[] $context
     *
     * @throws InvalidEmailModelException
     */
    public function __invoke(array $context) : void
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
