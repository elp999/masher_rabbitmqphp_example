<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once "vendor/autoload.php";
use Dotenv\Dotenv;

use Twilio\Rest\Client;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = $_ENV('TWILIO_SID');
$token = $_ENV('TWILIO_TOKEN');
$twilio = new Client($sid, $token);

$service = $twilio->messaging->v1->services->create(
    "My First Messaging Service" // FriendlyName
);

print $service->sid;
