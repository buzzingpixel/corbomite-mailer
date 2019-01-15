<?php
declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\factories;

use Html2Text\Html2Text;

class Html2TextFactory
{
    public function make(string $html = '', array $options = []): Html2Text
    {
        return new Html2Text($html, $options);
    }
}
