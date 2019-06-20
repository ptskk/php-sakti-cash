<?php
require_once('../Sakticash.php');

Sakticash_Config::$isProduction = false;
Sakticash_Config::$usernameKey = "<<CHANGE WITH YOUR MERCHANT USERNAME KEY>>";
Sakticash_Config::$passwordKey = "<<CHANGE WITH YOUR MERCHANT PASSWORD KEY>>";
Sakticash_Config::$auth = base64_encode(Sakticash_Config::$usernameKey . ":" . Sakticash_Config::$passwordKey);

$isConnected = Sakticash_Merchant::isConnected();

if ($isConnected) {
    var_dump(Sakticash_Merchant::getConfig());
} else {
    var_dump($isConnected);
}
