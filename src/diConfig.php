<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\di\Di;
use corbomite\queue\QueueApi;
use buzzingpixel\corbomitemailer\EmailApi;
use buzzingpixel\corbomitemailer\services\AddEmailToQueueService;
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
];
