<?php

declare(strict_types=1);

namespace buzzingpixel\tests\adapters\MandrillSendMailAdapter;

use buzzingpixel\corbomitemailer\adapters\MandrillSendMailAdapter;
use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use Mandrill;
use PHPUnit\Framework\TestCase;
use Throwable;

class EmailModelIsInvalidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $mandrill = self::createMock(Mandrill::class);

        $html2TextFactory = self::createMock(Html2TextFactory::class);

        $emailModel = self::createMock(EmailModelInterface::class);

        $emailModel->expects(self::once())
            ->method('isValid')
            ->willReturn(false);

        /** @noinspection PhpParamsInspection */
        $adapter = new MandrillSendMailAdapter(
            $mandrill,
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
