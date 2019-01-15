<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer\services;

use corbomite\queue\QueueApi;
use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;
use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;

class AddEmailToQueueService
{
    private $queueApi;

    public function __construct(QueueApi $queueApi)
    {
        $this->queueApi = $queueApi;
    }

    /**
     * @param EmailModelInterface $emailModel
     * @throws InvalidEmailModelException
     */
    public function __invoke(EmailModelInterface $emailModel)
    {
        $this->add($emailModel);
    }

    /**
     * @param EmailModelInterface $emailModel
     * @throws InvalidEmailModelException
     */
    public function add(EmailModelInterface $emailModel)
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
                    ])
                ]
            ])
        );
    }
}
