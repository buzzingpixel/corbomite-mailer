<?php

declare(strict_types=1);

namespace buzzingpixel\tests\adapters\SendGridSendMailAdapter;

use buzzingpixel\corbomitemailer\adapters\SendGridSendMailAdapter;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use Html2Text\Html2Text;
use PHPUnit\Framework\TestCase;
use SendGrid;
use SendGrid\Mail\Mail;
use Throwable;
use function getenv;

class EmailModelIsValidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $mail = self::createMock(Mail::class);

        $mail->expects(self::at(0))
            ->method('setFrom')
            ->with(
                self::equalTo(getenv('WEBMASTER_EMAIL_ADDRESS')),
                self::equalTo(getenv('WEBMASTER_NAME'))
            );

        $mail->expects(self::at(1))
            ->method('setReplyTo')
            ->with(
                self::equalTo('fromEmailTest'),
                self::equalTo(null)
            );

        $mail->expects(self::at(2))
            ->method('addTo')
            ->with(
                self::equalTo('toEmailTest'),
                self::equalTo(null)
            );

        $mail->expects(self::at(3))
            ->method('setSubject')
            ->with(self::equalTo('subjectTest'));

        $mail->expects(self::at(4))
            ->method('addContent')
            ->with(
                self::equalTo('text/plain'),
                self::equalTo('MessagePlainTextReturn')
            );

        $mail->expects(self::at(5))
            ->method('addContent')
            ->with(
                self::equalTo('text/html'),
                self::equalTo('messageHtmlReturn')
            );

        $sendGrid = self::createMock(SendGrid::class);

        $sendGrid->expects(self::once())
            ->method('send')
            ->with(self::equalTo($mail));

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
            ->method('fromEmail')
            ->willReturn('fromEmailTest');

        $emailModel->expects(self::at(2))
            ->method('fromEmail')
            ->willReturn('fromEmailTest');

        $emailModel->expects(self::at(3))
            ->method('fromName')
            ->willReturn('');

        $emailModel->expects(self::at(4))
            ->method('toEmail')
            ->willReturn('toEmailTest');

        $emailModel->expects(self::at(5))
            ->method('toName')
            ->willReturn('');

        $emailModel->expects(self::at(6))
            ->method('subject')
            ->willReturn('subjectTest');

        $emailModel->expects(self::at(7))
            ->method('messagePlainText')
            ->willReturn('');

        $emailModel->expects(self::at(8))
            ->method('messageHtml')
            ->willReturn('MessageHtmlTestReturn');

        $emailModel->expects(self::at(9))
            ->method('messagePlainText')
            ->with(self::equalTo('Html2TextGetTextTestReturn'))
            ->willReturn('');

        $emailModel->expects(self::at(10))
            ->method('messagePlainText')
            ->willReturn('MessagePlainTextReturn');

        $emailModel->expects(self::at(11))
            ->method('messageHtml')
            ->willReturn('messageHtmlReturn');

        $emailModel->expects(self::at(12))
            ->method('messageHtml')
            ->willReturn('messageHtmlReturn');

        /** @noinspection PhpParamsInspection */
        $adapter = new SendGridSendMailAdapter(
            $mail,
            $sendGrid,
            $html2TextFactory
        );

        /** @noinspection PhpParamsInspection */
        $adapter->send($emailModel);
    }
}
