<?php

declare(strict_types=1);

namespace buzzingpixel\tests\adapters\SendGridSendMailAdapter;

use buzzingpixel\corbomitemailer\adapters\SendGridSendMailAdapter;
use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use PHPUnit\Framework\TestCase;
use SendGrid;
use SendGrid\Mail\Mail;
use Throwable;

class EmailModelIsInvalidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $mail = self::createMock(Mail::class);

        $sendGrid = self::createMock(SendGrid::class);

        $html2TextFactory = self::createMock(Html2TextFactory::class);

        $emailModel = self::createMock(EmailModelInterface::class);

        $emailModel->expects(self::once())
            ->method('isValid')
            ->willReturn(false);

        /** @noinspection PhpParamsInspection */
        $adapter = new SendGridSendMailAdapter(
            $mail,
            $sendGrid,
            $html2TextFactory
        );

        $exception = null;

        try {
            /** @noinspection PhpParamsInspection */
            $adapter->send($emailModel);
        } catch (InvalidEmailModelException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(
            InvalidEmailModelException::class,
            $exception
        );

        self::assertEquals(
            'Invalid email model',
            $exception->getMessage()
        );
    }
}
