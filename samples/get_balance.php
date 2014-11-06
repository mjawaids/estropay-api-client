<?php

require_once '../src/EstroPayAPIClient.php';

$api_key = "[ENTER-YOUR-API-KEY-HERE]";
$o = new EstroPayAPIClient($api_key);

echo "Your current balance is $" . $o->balance()->balance;