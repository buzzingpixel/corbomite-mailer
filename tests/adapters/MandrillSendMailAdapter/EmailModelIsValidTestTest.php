<?php

declare(strict_types=1);

namespace buzzingpixel\tests\adapters\MandrillSendMailAdapter;

use buzzingpixel\corbomitemailer\adapters\MandrillSendMailAdapter;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use Html2Text\Html2Text;
use Mandrill;
use Mandrill_Messages;
use PHPUnit\Framework\TestCase;
use Throwable;

class EmailModelIsValidTestTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $mandrill = self::createMock(Mandrill::class);

        /** @noinspection PhpUndefinedFieldInspection */
        $mandrill->messages = self::createMock(Mandrill_Messages::class);

        /** @noinspection PhpUndefinedFieldInspection */
        $mandrill->messages->expects(self::once())
            ->method('send')
            ->with(self::equalTo([
                'text' => 'messagePlainTextTest',
                'subject' => 'subjectTest',
                'from_email' => 'testWebmasterEmailAddress',
                'from_name' => 'testWebmasterName',
                'to' => [
                    [
                        'email' => 'toEmailTest',
                        'name' => 'toEmailTest2',
                        'type' => 'to',
                    ],
                ],
                'important' => false,
                'track_opens' => true,
                'track_clicks' => true,
                'auto_text' => false,
                'auto_html' => false,
                'inline_css' => false,
                'url_strip_qs' => false,
                'preserve_recipients' => true,
                'view_content_link' => true,
                'bcc_address' => null,
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'html' => 'messageHtmlTest',
                'headers' =>
                    ['Reply-To' => 'fromEmailTest'],
            ]));

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
            ->method('messagePlainText')
            ->willReturn('messagePlainTextTest');

        $emailModel->expects(self::at(5))
            ->method('subject')
            ->willReturn('subjectTest');

        $emailModel->expects(self::at(6))
            ->method('toEmail')
            ->willReturn('toEmailTest');

        $emailModel->expects(self::at(7))
            ->method('toName')
            ->willReturn('');

        $emailModel->expects(self::at(8))
            ->method('toEmail')
            ->willReturn('toEmailTest2');

        $emailModel->expects(self::at(9))
            ->method('messageHtml')
            ->willReturn('messageHtmlTest');

        $emailModel->expects(self::at(10))
            ->method('messageHtml')
            ->willReturn('messageHtmlTest');

        $emailModel->expects(self::at(11))
            ->method('fromEmail')
            ->willReturn('fromEmailTest');

        $emailModel->expects(self::at(12))
            ->method('fromEmail')
            ->willReturn('fromEmailTest');

        /** @noinspection PhpParamsInspection */
        $adapter = new MandrillSendMailAdapter(
            $mandrill,
            $html2TextFactory
        );

        /** @noinspection PhpParamsInspection */
        $adapter->send($emailModel);
    }
}
