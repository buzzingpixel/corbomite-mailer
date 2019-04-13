<?php

declare(strict_types=1);

namespace buzzingpixel\tests\services\AddEmailToQueueServiceTest;

use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\services\AddEmailToQueueService;
use corbomite\queue\interfaces\QueueApiInterface;
use PHPUnit\Framework\TestCase;
use Throwable;

class EmailModelIsInvalidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $emailModel = self::createMock(EmailModelInterface::class);

        $emailModel->expects(self::once())
            ->method('isValid')
            ->willReturn(false);

        $queueApi = self::createMock(QueueApiInterface::class);

        /** @noinspection PhpParamsInspection */
        $service = new AddEmailToQueueService($queueApi);

        $exception = null;

        try {
            /** @noinspection PhpParamsInspection */
            $service($emailModel);
        } catch (InvalidEmailModelException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(InvalidEmailModelException::class, $exception);

        self::assertEquals('Invalid email model', $exception->getMessage());
    }
}
