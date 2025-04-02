<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once 'vendor/autoload.php';
use Twilio\Rest\Client;

$sid    = "ACc503a6379dfe2f243d7964aae894a770";
$token  = "20ff77056c773ad0772f065772552fb1";
$twilio = new Client($sid, $token);

$verification = $twilio->verify->v2->services("VA80db84a49a25999f942f15c527bc9fcc")
                                   ->verifications
                                   ->create("+12014244143", "sms");

print($verification->sid);
