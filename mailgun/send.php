<?php

require 'vendor/autoload.php';
use Mailgun\Mailgun;

$mgClient = new Mailgun(getenv('MAILGUN_API_KEY'));
$domain = getenv('MAILGUN_SMTP_LOGIN');
$domain = substr($domain, strpos($domain, '@') + 1);
$result = $mgClient->sendMessage($domain, array(
    'from'    => 'Excited User <me@samples.mailgun.org>',
    'to'      => 'yuji.ogihara.85@gmail.com',
    'subject' => 'Hello',
    'text'    => 'Testing some Mailgun awesomness!'
));