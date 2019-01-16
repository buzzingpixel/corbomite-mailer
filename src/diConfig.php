<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\di\Di;
use Mailgun\Mailgun;
use corbomite\queue\QueueApi;
use SendGrid\Mail\Mail as SendGridMail;
use buzzingpixel\corbomitemailer\EmailApi;
use buzzingpixel\corbomitemailer\factories\Html2TextFactory;
use buzzingpixel\corbomitemailer\adapters\MailGunSendMailAdapter;
use buzzingpixel\corbomitemailer\services\AddEmailToQueueService;
use buzzingpixel\corbomitemailer\adapters\MandrillSendMailAdapter;
use buzzingpixel\corbomitemailer\adapters\SendGridSendMailAdapter;
use buzzingpixel\corbomitemailer\services\SendEmailFromQueueService;

return [
    EmailApi::class => function () {
        return new EmailApi(new Di());
    },
    AddEmailToQueueService::class => function () {
        return new AddEmailToQueueService(Di::get(QueueApi::class));
    },
    SendEmailFromQueueService::class => function () {
        return new SendEmailFromQueueService(Di::get(EmailApi::class));
    },
    SendGridSendMailAdapter::class => function () {
        return new SendGridSendMailAdapter(
            new SendGridMail(),
            new \SendGrid(getenv('SENDGRID_API_KEY')),
            new Html2TextFactory()
        );
    },
    MandrillSendMailAdapter::class => function () {
        return new MandrillSendMailAdapter(
            new Mandrill(getenv('MANDRILL_API_KEY')),
            new Html2TextFactory()
        );
    },
    MailGunSendMailAdapter::class => function () {
        return new MailGunSendMailAdapter(
            Mailgun::create(getenv('MAILGUN_API_KEY')),
            new Html2TextFactory()
        );
    },
];
