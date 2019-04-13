<?php

declare(strict_types=1);

namespace buzzingpixel\tests\services;

use buzzingpixel\corbomitemailer\interfaces\EmailApiInterface;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\services\SendEmailFromQueueService;
use PHPUnit\Framework\TestCase;
use Throwable;

class SendEmailFromQueueServiceTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $emailModel = self::createMock(EmailModelInterface::class);

        $context = [
            'fromName' => 'fromNameTest',
            'fromEmail' => 'fromEmailTest',
            'toName' => 'toNameTest',
            'toEmail' => 'toEmailTest',
            'subject' => 'subjectTest',
            'messagePlainText' => 'messagePlainTextTest',
            'messageHtml' => 'messageHtmlTest',
        ];

        $emailApi = self::createMock(EmailApiInterface::class);

        $emailApi->expects(self::at(0))
            ->method('createEmailModel')
            ->with(self::equalTo($context))
            ->willReturn($emailModel);

        $emailApi->expects(self::at(1))
            ->method('sendEmail')
            ->with(self::equalTo($emailModel));

        /** @noinspection PhpParamsInspection */
        $service = new SendEmailFromQueueService($emailApi);

        $service($context);
    }
}
