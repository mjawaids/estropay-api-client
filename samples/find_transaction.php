<?php

require_once '../src/EstroPayAPIClient.php';

$api_key = "[ENTER-YOUR-API-KEY-HERE]";
$o = new EstroPayAPIClient($api_key);

// find transaction
$transaction_id = 10022;
$t = $o->transaction($transaction_id);
print_r($t);
