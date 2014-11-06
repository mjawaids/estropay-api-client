<?php

require_once '../src/EstroPayAPIClient.php';

$api_key = "[ENTER-YOUR-API-KEY-HERE]";
$o = new EstroPayAPIClient($api_key);

// transfer money
$amount = 10;
$receiver_account = 'E1005002';
$receiver_name = 'Client test';

$x = $o->transfer($amount, $receiver_account, $receiver_name);

print_r($x->transaction);
