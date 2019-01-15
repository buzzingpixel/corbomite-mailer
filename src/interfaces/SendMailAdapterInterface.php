<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer\interfaces;

use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;

interface SendMailAdapterInterface
{
    /**
     * Sends the email
     * @param EmailModelInterface $emailModel
     * @throws InvalidEmailModelException
     */
    public function send(EmailModelInterface $emailModel);
}
