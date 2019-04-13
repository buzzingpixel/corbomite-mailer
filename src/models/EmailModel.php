<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\models;

use buzzingpixel\corbomitemailer\interfaces\EmailModelInterface;

class EmailModel implements EmailModelInterface
{
    /**
     * @param mixed[] $props
     */
    public function __construct(array $props = [])
    {
        foreach ($props as $key => $val) {
            $this->{$key}($val);
        }
    }

    /** @var string */
    private $fromName = '';

    public function fromName(?string $fromName = null) : string
    {
        return $this->fromName = $fromName ?? $this->fromName;
    }

    /** @var string */
    private $fromEmail = '';

    public function fromEmail(?string $fromEmail = null) : string
    {
        return $this->fromEmail = $fromEmail ?? $this->fromEmail;
    }

    /** @var string */
    private $toName = '';

    public function toName(?string $toName = null) : string
    {
        return $this->toName = $toName ?? $this->toName;
    }

    /** @var string */
    private $toEmail = '';

    public function toEmail(?string $toEmail = null) : string
    {
        return $this->toEmail = $toEmail ?? $this->toEmail;
    }

    /** @var string */
    private $subject = '';

    public function subject(?string $subject = null) : string
    {
        return $this->subject = $subject ?? $this->subject;
    }

    /** @var string */
    private $messagePlainText = '';

    public function messagePlainText(?string $messagePlainText = null) : string
    {
        return $this->messagePlainText = $messagePlainText ?? $this->messagePlainText;
    }

    /** @var string */
    private $messageHtml = '';

    public function messageHtml(?string $messageHtml = null) : string
    {
        return $this->messageHtml = $messageHtml ?? $this->messageHtml;
    }

    public function isValid() : bool
    {
        if (! $this->toEmail() ||
            ! $this->subject()
        ) {
            return false;
        }

        return $this->messagePlainText() || $this->messageHtml();
    }
}
