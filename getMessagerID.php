<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once "vendor/autoload.php";

use Twilio\Rest\Client;

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = 'ACc503a6379dfe2f243d7964aae894a770';
$token = '20ff77056c773ad0772f065772552fb1';
$twilio = new Client($sid, $token);

$service = $twilio->messaging->v1->services->create(
    "My First Messaging Service" // FriendlyName
);

print $service->sid;
