<?php

declare(strict_types=1);

ini_set('display_errors', 'On');
ini_set('html_errors', '0');
error_reporting(-1);

session_start();

define('TESTS_BASE_PATH', __DIR__);

define('TESTING_APP_PATH', dirname(__DIR__));

putenv('WEBMASTER_NAME=testWebmasterName');

putenv('WEBMASTER_EMAIL_ADDRESS=testWebmasterEmailAddress');

putenv('MAILGUN_DOMAIN=testMailgunDomain');

require dirname(__DIR__) . '/vendor/autoload.php';
