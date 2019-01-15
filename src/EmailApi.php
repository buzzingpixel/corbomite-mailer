<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer;

use corbomite\di\Di;
use buzzingpixel\corbomitemailer\models\EmailModel;
use buzzingpixel\corbomitemailer\interfaces\EmailApiInterface;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\services\AddEmailToQueueService;
use buzzingpixel\corbomitemailer\interfaces\SendMailAdapterInterface;

class EmailApi implements EmailApiInterface
{
    private $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    public function createEmailModel(array $props = []): EmailModelInterface
    {
        return new EmailModel($props);
    }

    public function addEmailToQueue(EmailModelInterface $emailModel)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->di->getFromDefinition(AddEmailToQueueService::class)->add(
            $emailModel
        );
    }

    public function sendEmail(EmailModelInterface $emailModel)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var SendMailAdapterInterface $adapter */
        $adapter = $this->di->makeFromDefinition(
            getenv('CORBOMITE_MAILER_ADAPTER_CLASS')
        );
        $adapter->send($emailModel);
    }
}
