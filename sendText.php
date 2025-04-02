<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once 'vendor/autoload.php';
use Twilio\Rest\Client;
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$sid = $_ENV('TWILIO_SID');
$token = $_ENV('TWILIO_TOKEN');

$twilio = new Client($sid, $token);

$verification = $twilio->verify->v2->services($_ENV("TWILIO_SERVICES"))                                            ->verifications
                                   ->create("+12014244143", "sms");

print($verification->sid);
