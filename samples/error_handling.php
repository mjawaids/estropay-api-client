<?php

require_once '../src/EstroPayAPIClient.php';

$api_key = "[ENTER-YOUR-API-KEY-HERE]";
$o = new EstroPayAPIClient($api_key);

// find transaction
$transaction_id = 100221;   // invalid transaction id
$t = $o->transaction($transaction_id);

if ($o->isError()) {
    echo "There is an error ".$o->getCode();    // displays error code. See http://www.estropay.com/home/developers for code descriptions.
} else {
    echo "Your found transaction is:";
    print_r($t);
}
