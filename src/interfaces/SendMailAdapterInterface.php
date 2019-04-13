<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\interfaces;

use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;

interface SendMailAdapterInterface
{
    /**
     * Sends the email
     *
     * @return mixed
     *
     * @throws InvalidEmailModelException
     */
    public function send(EmailModelInterface $emailModel);
}
