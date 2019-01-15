<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer\interfaces;

use buzzingpixel\corbomitemailer\exceptions\InvalidEmailModelException;

interface EmailApiInterface
{
    /**
     * Creates an email model
     * @param array $props
     * @return EmailModelInterface
     */
    public function createEmailModel(array $props = []): EmailModelInterface;

    /**
     * Adds an email to the queue
     * @param EmailModelInterface $emailModel
     * @throws InvalidEmailModelException
     */
    public function addEmailToQueue(EmailModelInterface $emailModel);

    /**
     * Sends an email right away
     * @param EmailModelInterface $emailModel
     * @throws InvalidEmailModelException
     */
    public function sendEmail(EmailModelInterface $emailModel);
}
