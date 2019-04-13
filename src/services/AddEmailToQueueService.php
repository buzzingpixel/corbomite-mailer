<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\services;

use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use corbomite\queue\interfaces\QueueApiInterface;

class AddEmailToQueueService
{
    /** @var QueueApiInterface */
    private $queueApi;

    public function __construct(QueueApiInterface $queueApi)
    {
        $this->queueApi = $queueApi;
    }

    /**
     * @throws InvalidEmailModelException
     */
    public function __invoke(EmailModelInterface $emailModel) : void
    {
        $this->add($emailModel);
    }

    /**
     * @throws InvalidEmailModelException
     */
    public function add(EmailModelInterface $emailModel) : void
    {
        if (! $emailModel->isValid()) {
            throw new InvalidEmailModelException();
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->queueApi->addToQueue(
            $this->queueApi->makeActionQueueBatchModel([
                'name' => 'corbomite-mailer',
                'title' => 'Corbomite Mailer',
                'items' => [
                    $this->queueApi->makeActionQueueItemModel([
                        'class' => SendEmailFromQueueService::class,
                        'context' => [
                            'fromName' => $emailModel->fromName(),
                            'fromEmail' => $emailModel->fromEmail(),
                            'toName' => $emailModel->toName(),
                            'toEmail' => $emailModel->toEmail(),
                            'subject' => $emailModel->subject(),
                            'messagePlainText' => $emailModel->messagePlainText(),
                            'messageHtml' => $emailModel->messageHtml(),
                        ],
                    ]),
                ],
            ])
        );
    }
}
