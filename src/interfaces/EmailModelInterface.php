<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\interfaces;

interface EmailModelInterface
{
    /**
     * EmailModelInterface constructor sets incoming properties as available
     *
     * @param mixed[] $props
     */
    public function __construct(array $props = []);

    /**
     * Returns from name. Sets value if $fromName argument provided
     */
    public function fromName(?string $fromName = null) : string;

    /**
     * Returns from email. Sets value if $fromEmail argument provided
     */
    public function fromEmail(?string $fromEmail = null) : string;

    /**
     * Returns to name. Sets value if $toName argument provided
     */
    public function toName(?string $toName = null) : string;

    /**
     * Returns to email. Sets value if $toEmail argument provided
     */
    public function toEmail(?string $toEmail = null) : string;

    /**
     * Returns subject. Sets value if $subject argument provided
     */
    public function subject(?string $subject = null) : string;

    /**
     * Returns message plain text. Sets value if $messagePlainText argument provided
     */
    public function messagePlainText(?string $messagePlainText = null) : string;

    /**
     * Returns message html. Sets value if $messageHtml argument provided
     */
    public function messageHtml(?string $messageHtml = null) : string;

    /**
     * Checks whether the model has all it needs to send an email
     */
    public function isValid() : bool;
}
