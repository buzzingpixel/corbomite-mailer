<?php

declare(strict_types=1);

namespace buzzingpixel\tests\models;

use buzzingpixel\corbomitemailer\models\EmailModel;
use PHPUnit\Framework\TestCase;

class EmailModelTest extends TestCase
{
    public function testFromName() : void
    {
        $model = new EmailModel();

        self::assertEmpty($model->fromName());

        self::assertEquals('testVal', $model->fromName('testVal'));

        self::assertEquals('testVal', $model->fromName());

        $model = new EmailModel(['fromName' => 'fromConstructor']);

        self::assertEquals('fromConstructor', $model->fromName());
    }

    public function testFromEmail() : void
    {
        $model = new EmailModel();

        self::assertEmpty($model->fromEmail());

        self::assertEquals('testVal', $model->fromEmail('testVal'));

        self::assertEquals('testVal', $model->fromEmail());

        $model = new EmailModel(['fromEmail' => 'fromConstructor']);

        self::assertEquals('fromConstructor', $model->fromEmail());
    }

    public function testToName() : void
    {
        $model = new EmailModel();

        self::assertEmpty($model->toName());

        self::assertEquals('testVal', $model->toName('testVal'));

        self::assertEquals('testVal', $model->toName());

        $model = new EmailModel(['toName' => 'fromConstructor']);

        self::assertEquals('fromConstructor', $model->toName());
    }

    public function testToEmail() : void
    {
        $model = new EmailModel();

        self::assertEmpty($model->toEmail());

        self::assertEquals('testVal', $model->toEmail('testVal'));

        self::assertEquals('testVal', $model->toEmail());

        $model = new EmailModel(['toEmail' => 'fromConstructor']);

        self::assertEquals('fromConstructor', $model->toEmail());
    }

    public function testSubject() : void
    {
        $model = new EmailModel();

        self::assertEmpty($model->subject());

        self::assertEquals('testVal', $model->subject('testVal'));

        self::assertEquals('testVal', $model->subject());

        $model = new EmailModel(['subject' => 'fromConstructor']);

        self::assertEquals('fromConstructor', $model->subject());
    }

    public function testMessagePlainText() : void
    {
        $model = new EmailModel();

        self::assertEmpty($model->messagePlainText());

        self::assertEquals('testVal', $model->messagePlainText('testVal'));

        self::assertEquals('testVal', $model->messagePlainText());

        $model = new EmailModel(['messagePlainText' => 'fromConstructor']);

        self::assertEquals('fromConstructor', $model->messagePlainText());
    }

    public function testMessageHtml() : void
    {
        $model = new EmailModel();

        self::assertEmpty($model->messageHtml());

        self::assertEquals('testVal', $model->messageHtml('testVal'));

        self::assertEquals('testVal', $model->messageHtml());

        $model = new EmailModel(['messageHtml' => 'fromConstructor']);

        self::assertEquals('fromConstructor', $model->messageHtml());
    }

    public function testIsValid() : void
    {
        $model = new EmailModel();
        self::assertFalse($model->isValid());

        $model->toEmail('asdf');
        self::assertFalse($model->isValid());

        $model->toEmail('');
        $model->subject('asdf');
        self::assertFalse($model->isValid());

        $model->toEmail('asdf');
        self::assertFalse($model->isValid());

        $model->messagePlainText('asdf');
        self::assertTrue($model->isValid());

        $model->messagePlainText('');
        $model->messageHtml('asdf');
        self::assertTrue($model->isValid());

        $model->messagePlainText('');
        $model->messageHtml('');
        self::assertFalse($model->isValid());
    }
}
