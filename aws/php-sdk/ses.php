<?php

// Replace path_to_sdk_inclusion with the path to the SDK as described in
// http://docs.aws.amazon.com/aws-sdk-php/v3/guide/getting-started/basic-usage.html
define('REQUIRED_FILE','vendor/autoload.php');

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
define('SENDER', 'yuji.ogihara.85@gmail.com');

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
define('RECIPIENT', 'hoegaarden1917@gmail.com');

// Replace us-west-2 with the AWS region you're using for Amazon SES.
define('REGION','us-east-1');

define('SUBJECT','Amazon SES test (AWS SDK for PHP)');
define('BODY','This email was sent with Amazon SES using the AWS SDK for PHP.');

require REQUIRED_FILE;

use Aws\Ses\SesClient;

$client = SesClient::factory(array(
    'version'=> 'latest',
        'region' => REGION
	));

$request = array();
$request['Source'] = SENDER;
$request['Destination']['ToAddresses'] = array(RECIPIENT);
$request['Destination']['CcAddresses'] = array(SENDER);
$request['Message']['Subject']['Data'] = SUBJECT;
$request['Message']['Body']['Text']['Data'] = BODY;

try {
     $result = $client->sendEmail($request);
          $messageId = $result->get('MessageId');
	       echo("Email sent! Message ID: $messageId"."\n");

} catch (Exception $e) {
     echo("The email was not sent. Error message: ");
          echo($e->getMessage()."\n");
	  }

?>