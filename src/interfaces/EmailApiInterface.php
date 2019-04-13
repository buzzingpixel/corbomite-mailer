<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\interfaces;

use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;

interface EmailApiInterface
{
    /**
     * Creates an email model
     *
     * @param mixed[] $props
     */
    public function createEmailModel(array $props = []) : EmailModelInterface;

    /**
     * Adds an email to the queue
     *
     * @return mixed
     *
     * @throws InvalidEmailModelException
     */
    public function addEmailToQueue(EmailModelInterface $emailModel);

    /**
     * Sends an email right away
     *
     * @return mixed
     *
     * @throws InvalidEmailModelException
     */
    public function sendEmail(EmailModelInterface $emailModel);
}
