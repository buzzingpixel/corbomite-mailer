<?php

declare(strict_types=1);

namespace buzzingpixel\tests\adapters\PostMarkSendMailAdapter;

use buzzingpixel\corbomitemailer\adapters\PostMarkSendMailAdapter;
use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use PHPUnit\Framework\TestCase;
use Postmark\PostmarkClient;
use Throwable;

class EmailModelIsInvalidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $postmark = self::createMock(PostmarkClient::class);

        $html2TextFactory = self::createMock(Html2TextFactory::class);

        $emailModel = self::createMock(EmailModelInterface::class);

        $emailModel->expects(self::once())
            ->method('isValid')
            ->willReturn(false);

        /** @noinspection PhpParamsInspection */
        $adapter = new PostMarkSendMailAdapter(
            $postmark,
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
