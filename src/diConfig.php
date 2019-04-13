<?php

declare(strict_types=1);

use buzzingpixel\corbomitemailer\adapters\MailGunSendMailAdapter;
use buzzingpixel\corbomitemailer\adapters\MandrillSendMailAdapter;
use buzzingpixel\corbomitemailer\adapters\PostMarkSendMailAdapter;
use buzzingpixel\corbomitemailer\adapters\SendGridSendMailAdapter;
use buzzingpixel\corbomitemailer\EmailApi;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\interfaces\EmailApiInterface;
use buzzingpixel\corbomitemailer\services\AddEmailToQueueService;
use buzzingpixel\corbomitemailer\services\SendEmailFromQueueService;
use corbomite\queue\QueueApi;
use Mailgun\Mailgun;
use Postmark\PostmarkClient;
use Psr\Container\ContainerInterface;
use SendGrid\Mail\Mail as SendGridMail;

return [
    EmailApi::class => static function (ContainerInterface $di) {
        return new EmailApi($di);
    },
    EmailApiInterface::class => static function (ContainerInterface $di) {
        return $di->get(EmailApi::class);
    },
    AddEmailToQueueService::class => static function (ContainerInterface $di) {
        return new AddEmailToQueueService(
            $di->get(QueueApi::class)
        );
    },
    SendEmailFromQueueService::class => static function (ContainerInterface $di) {
        return new SendEmailFromQueueService(
            $di->get(EmailApiInterface::class)
        );
    },
    SendGridSendMailAdapter::class => static function () {
        return new SendGridSendMailAdapter(
            new SendGridMail(),
            new SendGrid(getenv('SENDGRID_API_KEY')),
            new Html2TextFactory()
        );
    },
    MandrillSendMailAdapter::class => static function () {
        return new MandrillSendMailAdapter(
            new Mandrill(getenv('MANDRILL_API_KEY')),
            new Html2TextFactory()
        );
    },
    MailGunSendMailAdapter::class => static function () {
        return new MailGunSendMailAdapter(
            Mailgun::create(getenv('MAILGUN_API_KEY')),
            new Html2TextFactory()
        );
    },
    PostMarkSendMailAdapter::class => static function () {
        return new PostMarkSendMailAdapter(
            new PostmarkClient(getenv('POSTMARK_SERVER_TOKEN')),
            new Html2TextFactory()
        );
    },
];
