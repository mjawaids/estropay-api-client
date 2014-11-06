<?php

require_once '../src/EstroPayAPIClient.php';

$api_key = "[ENTER-YOUR-API-KEY-HERE]";
$o = new EstroPayAPIClient($api_key);

// complete history
$his = $o->history();
print_r($his->transactions);