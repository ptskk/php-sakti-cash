<?php
require_once('../Sakticash.php');

Sakticash_Config::$isProduction = false;
Sakticash_Config::$usernameKey = "SzIvUmM2-bGkzWGdG-WmVES1lZ-bE14aldQ-VExtODNM-SlNpMXY5-OXRzay93-MD0=";
Sakticash_Config::$passwordKey = "YUtWRE00-YWUrRGtY-bHJxMnFV-cVpXakdC-U1FoT3JZ-RWhHdkd4-cEtGVmN5-VT0=";
Sakticash_Config::$auth = base64_encode(Sakticash_Config::$usernameKey . ":" . Sakticash_Config::$passwordKey);

$isConnected = Sakticash_Merchant::isConnected();

if ($isConnected) {
    var_dump(Sakticash_Merchant::getConfig());
} else {
    var_dump($isConnected);
}
