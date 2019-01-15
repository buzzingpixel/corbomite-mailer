<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\corbomitemailer\interfaces;

interface EmailModelInterface
{
    /**
     * EmailModelInterface constructor sets incoming properties as available
     * @param array $props
     */
    public function __construct(array $props = []);

    /**
     * Returns from name. Sets value if $fromName argument provided
     * @param string|null $fromName
     * @return string
     */
    public function fromName(?string $fromName = null): string;

    /**
     * Returns from email. Sets value if $fromEmail argument provided
     * @param string|null $fromEmail
     * @return string
     */
    public function fromEmail(?string $fromEmail = null): string;

    /**
     * Returns to name. Sets value if $toName argument provided
     * @param string|null $toName
     * @return string
     */
    public function toName(?string $toName = null): string;

    /**
     * Returns to email. Sets value if $toEmail argument provided
     * @param string|null $toEmail
     * @return string
     */
    public function toEmail(?string $toEmail = null): string;

    /**
     * Returns subject. Sets value if $subject argument provided
     * @param string|null $subject
     * @return string
     */
    public function subject(?string $subject = null): string;

    /**
     * Returns message plain text. Sets value if $messagePlainText argument provided
     * @param string|null $messagePlainText
     * @return string
     */
    public function messagePlainText(?string $messagePlainText = null): string;

    /**
     * Returns message html. Sets value if $messageHtml argument provided
     * @param string|null $messageHtml
     * @return string
     */
    public function messageHtml(?string $messageHtml = null): string;

    /**
     * Checks whether the model has all it needs to send an email
     * @return bool
     */
    public function isValid(): bool;
}
