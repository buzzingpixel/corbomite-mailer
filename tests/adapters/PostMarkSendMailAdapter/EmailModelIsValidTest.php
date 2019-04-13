<?php

declare(strict_types=1);

namespace buzzingpixel\tests\adapters\PostMarkSendMailAdapter;

use buzzingpixel\corbomitemailer\adapters\PostMarkSendMailAdapter;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use Html2Text\Html2Text;
use PHPUnit\Framework\TestCase;
use Postmark\PostmarkClient;
use Throwable;

class EmailModelIsValidTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $postmark = self::createMock(PostmarkClient::class);

        $postmark->expects(self::once())
            ->method('sendEmail')
            ->with(
                self::equalTo('testWebmasterEmailAddress'),
                self::equalTo('toNameTest <toEmailTest>'),
                self::equalTo('subjectTest'),
                self::equalTo(null),
                self::equalTo('messagePlainTextTest'),
                self::equalTo(null),
                self::equalTo(true),
                self::equalTo('fromNameTest <fromEmailTest>'),
                self::equalTo(null),
                self::equalTo(null),
                self::equalTo(null),
                self::equalTo(null),
                self::equalTo('HtmlAndText'),
                self::equalTo(null)
            );

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
            ->willReturn('toEmailTest');

        $emailModel->expects(self::at(5))
            ->method('toName')
            ->willReturn('toNameTest');

        $emailModel->expects(self::at(6))
            ->method('toName')
            ->willReturn('toNameTest');

        $emailModel->expects(self::at(7))
            ->method('fromEmail')
            ->willReturn('fromEmailTest');

        $emailModel->expects(self::at(8))
            ->method('fromName')
            ->willReturn('fromNameTest');

        $emailModel->expects(self::at(9))
            ->method('fromName')
            ->willReturn('fromNameTest');

        $emailModel->expects(self::at(10))
            ->method('fromName')
            ->willReturn('fromNameTest');

        $emailModel->expects(self::at(11))
            ->method('fromEmail')
            ->willReturn('fromEmailTest');

        $emailModel->expects(self::at(12))
            ->method('subject')
            ->willReturn('subjectTest');

        $emailModel->expects(self::at(13))
            ->method('messageHtml')
            ->willReturn('');

        $emailModel->expects(self::at(14))
            ->method('messagePlainText')
            ->willReturn('messagePlainTextTest');

        /** @noinspection PhpParamsInspection */
        $adapter = new PostMarkSendMailAdapter(
            $postmark,
            $html2TextFactory
        );

        /** @noinspection PhpParamsInspection */
        $adapter->send($emailModel);
    }
}
