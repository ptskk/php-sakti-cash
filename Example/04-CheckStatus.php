<?php
require_once('../Sakticash.php');

Sakticash_Config::$isProduction = false;
Sakticash_Config::$usernameKey = "<<CHANGE WITH YOUR MERCHANT USERNAME KEY>>";
Sakticash_Config::$passwordKey = "<<CHANGE WITH YOUR MERCHANT PASSWORD KEY>>";
Sakticash_Config::$auth = base64_encode(Sakticash_Config::$usernameKey . ":" . Sakticash_Config::$passwordKey);

$isConnected = Sakticash_Merchant::isConnected();

if ($isConnected) {
    $trasaction_id = '11111114'; // from previous transaction (CreateQRCode)
    $status = Sakticash_Merchant::checkStatus($trasaction_id);
    var_dump($status);
} else {
    var_dump($isConnected);
}
