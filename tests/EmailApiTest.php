<?php

declare(strict_types=1);

namespace buzzingpixel\tests;

use buzzingpixel\corbomitemailer\EmailApi;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\interfaces\SendMailAdapterInterface;
use buzzingpixel\corbomitemailer\models\EmailModel;
use buzzingpixel\corbomitemailer\services\AddEmailToQueueService;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Throwable;
use function putenv;

class EmailApiTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testCreateEmailModel() : void
    {
        $di = self::createMock(ContainerInterface::class);

        /** @noinspection PhpParamsInspection */
        $api = new EmailApi($di);

        $model = $api->createEmailModel(['fromName' => 'fromNameTest']);

        self::assertInstanceOf(EmailModel::class, $model);

        self::assertEquals('fromNameTest', $model->fromName());
    }

    /**
     * @throws Throwable
     */
    public function testAddEmailToQueue() : void
    {
        $emailModel = self::createMock(EmailModelInterface::class);

        $addEmailToQueueService = self::createMock(AddEmailToQueueService::class);

        $addEmailToQueueService->expects(self::once())
            ->method('add')
            ->with(self::equalTo($emailModel));

        $di = self::createMock(ContainerInterface::class);

        $di->expects(self::once())
            ->method('get')
            ->with(self::equalTo(AddEmailToQueueService::class))
            ->willReturn($addEmailToQueueService);

        /** @noinspection PhpParamsInspection */
        $api = new EmailApi($di);

        /** @noinspection PhpParamsInspection */
        $api->addEmailToQueue($emailModel);
    }

    /**
     * @throws Throwable
     */
    public function testSendEmail() : void
    {
        putenv('CORBOMITE_MAILER_ADAPTER_CLASS=testAdapterClass');

        $emailModel = self::createMock(EmailModelInterface::class);

        $adapter = self::createMock(SendMailAdapterInterface::class);

        $adapter->expects(self::once())
            ->method('send')
            ->with(self::equalTo($emailModel));

        $di = self::createMock(ContainerInterface::class);

        $di->expects(self::once())
            ->method('get')
            ->with(self::equalTo('testAdapterClass'))
            ->willReturn($adapter);

        /** @noinspection PhpParamsInspection */
        $api = new EmailApi($di);

        /** @noinspection PhpParamsInspection */
        $api->sendEmail($emailModel);
    }
}
