<?php

declare(strict_types=1);

namespace buzzingpixel\tests\services\AddEmailToQueueServiceTest;

use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\services\AddEmailToQueueService;
use buzzingpixel\corbomitemailer\services\SendEmailFromQueueService;
use corbomite\queue\interfaces\ActionQueueBatchModelInterface;
use corbomite\queue\interfaces\ActionQueueItemModelInterface;
use corbomite\queue\interfaces\QueueApiInterface;
use PHPUnit\Framework\TestCase;
use Throwable;

class EmailModelIsValidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $emailModel = self::createMock(EmailModelInterface::class);

        $emailModel->expects(self::at(0))
            ->method('isValid')
            ->willReturn(true);

        $emailModel->expects(self::at(1))
            ->method('fromName')
            ->willReturn('fromNameTest');

        $emailModel->expects(self::at(2))
            ->method('fromEmail')
            ->willReturn('fromEmailTest');

        $emailModel->expects(self::at(3))
            ->method('toName')
            ->willReturn('toNameTest');

        $emailModel->expects(self::at(4))
            ->method('toEmail')
            ->willReturn('toEmailTest');

        $emailModel->expects(self::at(5))
            ->method('subject')
            ->willReturn('subjectTest');

        $emailModel->expects(self::at(6))
            ->method('messagePlainText')
            ->willReturn('messagePlainTextTest');

        $emailModel->expects(self::at(7))
            ->method('messageHtml')
            ->willReturn('messageHtmlTest');

        $queueBatchModel = self::createMock(ActionQueueBatchModelInterface::class);

        $queueItemModel = self::createMock(ActionQueueItemModelInterface::class);

        $queueApi = self::createMock(QueueApiInterface::class);

        $queueApi->expects(self::once())
            ->method('makeActionQueueItemModel')
            ->with(
                self::equalTo([
                    'class' => SendEmailFromQueueService::class,
                    'context' => [
                        'fromName' => 'fromNameTest',
                        'fromEmail' => 'fromEmailTest',
                        'toName' => 'toNameTest',
                        'toEmail' => 'toEmailTest',
                        'subject' => 'subjectTest',
                        'messagePlainText' => 'messagePlainTextTest',
                        'messageHtml' => 'messageHtmlTest',
                    ],
                ])
            )
            ->willReturn($queueItemModel);

        $queueApi->expects(self::once())
            ->method('makeActionQueueBatchModel')
            ->with(self::equalTo([
                'name' => 'corbomite-mailer',
                'title' => 'Corbomite Mailer',
                'items' => [$queueItemModel],
            ]))
            ->willReturn($queueBatchModel);

        $queueApi->expects(self::once())
            ->method('addToQueue')
            ->with($queueBatchModel);

        /** @noinspection PhpParamsInspection */
        $service = new AddEmailToQueueService($queueApi);

        /** @noinspection PhpParamsInspection */
        $service($emailModel);
    }
}
