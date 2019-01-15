#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\di\Di;
use corbomite\cli\Kernel;
use buzzingpixel\corbomitemailer\EmailApi;

define('ENTRY_POINT', 'app');
define('APP_BASE_PATH', __DIR__);
define('APP_VENDOR_PATH', APP_BASE_PATH . '/vendor');

putenv('DB_HOST=db');
putenv('DB_DATABASE=site');
putenv('DB_USER=site');
putenv('DB_PASSWORD=secret');
putenv('CORBOMITE_DB_DATA_NAMESPACE=corbomite\corbomitemailer\data');
putenv('CORBOMITE_DB_DATA_DIRECTORY=./src/data');

require APP_VENDOR_PATH . '/autoload.php';

if (file_exists(APP_BASE_PATH . '/.env')) {
    (new Dotenv\Dotenv(APP_BASE_PATH))->load();
}

// $emailApi = Di::get(EmailApi::class);
// $emailApi->addEmailToQueue($emailApi->createEmailModel([
//     'fromName' => 'Jim Kirk',
//     'fromEmail' => 'jkirk@starfleet.com',
//     'toName' => 'TJ Draper',
//     'toEmail' => 'tj@buzzingpixel.com',
//     'subject' => 'Test Email',
//     'messagePlainText' => 'This is a test.',
//     'messageHtml' => '<p>This is a test.</p>',
// ]));
// die;

/** @noinspection PhpUnhandledExceptionInspection */
Di::get(Kernel::class)($argv);
exit();
