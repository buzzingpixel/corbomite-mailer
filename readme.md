# Corbomite Mailer

Part of BuzzingPixel's Corbomite project.

Provides transaction email capabilities.

## Usage

### Queue

The Mailer makes use of the Corobomite Queue feature so be sure you have the queue running.

### Webmaster From and Email environment variables

For desirability, emails are ways sent from the the webmaster email. Be sure to set the following environment variables:

- `WEBMASTER_EMAIL_ADDRESS=info@mysite.com`
- `WEBMASTER_NAME="Some Name"`

### CORBOMITE_MAILER_ADAPTER_CLASS environment variable

To set what adapter the mailer uses, make sure to set the `CORBOMITE_MAILER_ADAPTER_CLASS` environment variable to a fully qualified class name of one of an adapter. The built in adapters are:

- `buzzingpixel\corbomitemailer\adapters\SendGridSendMailAdapter`
- `buzzingpixel\corbomitemailer\adapters\MandrillMailSendMailAdapter`
- `buzzingpixel\corbomitemailer\adapters\MailGunSendMailAdapter`
- `buzzingpixel\corbomitemailer\adapters\PostMarkSendMailAdapter`

You can also write your own adapter. It must implement `buzzingpixel\corbomitemailer\interfaces\SendMailAdapterInterface`.

### Adapter Environment variables

#### SendGridSendMailAdapter

To use the `SendGridSendMailAdapter`, be sure to set the `SENDGRID_API_KEY` environment variable.

#### MandrillMailSendMailAdapter

To use the `MandrillMailSendMailAdapter`, be sure to set the `MANDRILL_API_KEY` environment variable.

### MailGunSendMailAdapter

To use the `MailGunSendMailAdapter`, be sure to set the `MAILGUN_API_KEY` and `MAILGUN_DOMAIN` environment variables.

### PostMarkSendMailAdapter

To use the `PostMarkSendMailAdapter`, be sure to set the `POSTMARK_SERVER_TOKEN` environment variable.

### Sending email

```php
<?php
declare(strict_types=1);

use corbomite\di\Di;
use buzzingpixel\corbomitemailer\EmailApi;

$emailApi = Di::get(EmailApi::class);

$emailModel = $this->emailApi->createEmailModel([
    'fromName' => 'Some Name', // Optional, fromEmail must be set
    'fromEmail' => 'Some Email', // Optional
    'toName' => 'Some Name', // Optional
    'toEmail' => 'someone@domain.com', // Required
    'subject' => 'Some Subject', // Required
    'messagePlainText' => 'Plaintext Content', // Required if messageHtml not set. Derived from messageHtml if not set
    'messageHtml' => '<p>Html Content</p>', // Required if messagePlainText not set
]);

// Add the email to the queue and let the queue runner send it (recommended)
$emailApi->addEmailToQueue($emailModel);

// Send the email right away (avoid if possible)
$emailApi->sendEmail($emailModel);
```

## License

Copyright 2019 BuzzingPixel, LLC

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at [http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0).

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
