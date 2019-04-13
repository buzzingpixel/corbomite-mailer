<?php

declare(strict_types=1);

namespace buzzingpixel\tests\adapters\MailGunSendMailAdapter;

use buzzingpixel\corbomitemailer\adapters\MailGunSendMailAdapter;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use Html2Text\Html2Text;
use Mailgun\Api\Message;
use Mailgun\Mailgun;
use PHPUnit\Framework\TestCase;
use Throwable;

class EmailModelIsValidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $mailGunMessage = self::createMock(Message::class);

        $mailGunMessage->expects(self::once())
            ->method('send')
            ->with(
                self::equalTo('testMailgunDomain'),
                self::equalTo([
                    'from' => 'testWebmasterName <testWebmasterEmailAddress>',
                    'to' => 'testToEmail',
                    'subject' => 'testSubject',
                    'text' => 'testMessagePlainText',
                    'h:Reply-To' => 'testFromName <testFromEmail>',
                    'html' => 'testMessageHtml',
                ])
            );

        $mailgun = self::createMock(Mailgun::class);

        $mailgun->expects(self::once())
            ->method('messages')
            ->willReturn($mailGunMessage);

        $html2Text = self::createMock(Html2Text::class);

        $html2Text->expects(self::once())
            ->method('getText')
            ->willReturn('Html2TextGetTextTestReturn');

        $html2TextFactory = self::createMock(Html2TextFactory::class);

        $html2TextFactory->expects(self::once())
            ->method('make')
            ->willReturn($html2Text);

        $emailModel = self::createMock(EmailModelInterface::class);

        $emailModel->expects(self::at(0))
            ->method('isValid')
            ->willReturn(true);

        $emailModel->expects(self::at(1))
            ->method('messagePlainText')
            ->willReturn('');

        $emailModel->expects(self::at(2))
            ->method('messageHtml')
            ->willReturn('MessageHtmlTestReturn');

        $emailModel->expects(self::at(3))
            ->method('messagePlainText')
            ->with(self::equalTo('Html2TextGetTextTestReturn'))
            ->willReturn('');

        $emailModel->expects(self::at(4))
            ->method('toEmail')
            ->willReturn('testToEmail');

        $emailModel->expects(self::at(5))
            ->method('subject')
            ->willReturn('testSubject');

        $emailModel->expects(self::at(6))
            ->method('messagePlainText')
            ->willReturn('testMessagePlainText');

        $emailModel->expects(self::at(7))
            ->method('fromEmail')
            ->willReturn('testFromEmail');

        $emailModel->expects(self::at(8))
            ->method('fromEmail')
            ->willReturn('testFromEmail');

        $emailModel->expects(self::at(9))
            ->method('fromName')
            ->willReturn('testFromName');

        $emailModel->expects(self::at(10))
            ->method('fromName')
            ->willReturn('testFromName');

        $emailModel->expects(self::at(11))
            ->method('fromEmail')
            ->willReturn('testFromEmail');

        $emailModel->expects(self::at(12))
            ->method('messageHtml')
            ->willReturn('testMessageHtml');

        $emailModel->expects(self::at(13))
            ->method('messageHtml')
            ->willReturn('testMessageHtml');

        /** @noinspection PhpParamsInspection */
        $adapter = new MailGunSendMailAdapter(
            $mailgun,
            $html2TextFactory
        );

        /** @noinspection PhpParamsInspection */
        $adapter->send($emailModel);
    }
}
