<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer\models;

use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;

class EmailModel implements EmailModelInterface
{
    public function __construct(array $props = [])
    {
        foreach ($props as $key => $val) {
            $this->{$key}($val);
        }
    }

    private $fromName = '';

    public function fromName(?string $fromName = null): string
    {
        return $this->fromName = $fromName !== null ? $fromName : $this->fromName;
    }

    private $fromEmail = '';

    public function fromEmail(?string $fromEmail = null): string
    {
        return $this->fromEmail = $fromEmail !== null ? $fromEmail : $this->fromEmail;
    }

    private $toName = '';

    public function toName(?string $toName = null): string
    {
        return $this->toName = $toName !== null ? $toName : $this->toName;
    }

    private $toEmail = '';

    public function toEmail(?string $toEmail = null): string
    {
        return $this->toEmail = $toEmail !== null ? $toEmail : $this->toEmail;
    }

    private $subject = '';

    public function subject(?string $subject = null): string
    {
        return $this->subject = $subject !== null ? $subject : $this->subject;
    }

    private $messagePlainText = '';

    public function messagePlainText(?string $messagePlainText = null): string
    {
        return $this->messagePlainText = $messagePlainText !== null ? $messagePlainText : $this->messagePlainText;
    }

    private $messageHtml = '';

    public function messageHtml(?string $messageHtml = null): string
    {
        return $this->messageHtml = $messageHtml !== null ? $messageHtml : $this->messageHtml;
    }
}
