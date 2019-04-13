<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer;

use buzzingpixel\corbomitemailer\interfaces\EmailApiInterface;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\interfaces\SendMailAdapterInterface;
use buzzingpixel\corbomitemailer\models\EmailModel;
use buzzingpixel\corbomitemailer\services\AddEmailToQueueService;
use Psr\Container\ContainerInterface;
use function getenv;

class EmailApi implements EmailApiInterface
{
    /** @var ContainerInterface */
    private $di;

    public function __construct(ContainerInterface $di)
    {
        $this->di = $di;
    }

    /**
     * @param mixed[] $props
     */
    public function createEmailModel(array $props = []) : EmailModelInterface
    {
        return new EmailModel($props);
    }

    public function addEmailToQueue(EmailModelInterface $emailModel) : void
    {
        $this->di->get(AddEmailToQueueService::class)->add(
            $emailModel
        );
    }

    public function sendEmail(EmailModelInterface $emailModel) : void
    {
        /** @var SendMailAdapterInterface $adapter */
        $adapter = $this->di->get(getenv('CORBOMITE_MAILER_ADAPTER_CLASS'));
        $adapter->send($emailModel);
    }
}
