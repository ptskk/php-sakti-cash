<?php
require_once('../Sakticash.php');

Sakticash_Config::$isProduction = false;
Sakticash_Config::$usernameKey = "<<CHANGE WITH YOUR MERCHANT USERNAME KEY>>";
Sakticash_Config::$passwordKey = "<<CHANGE WITH YOUR MERCHANT PASSWORD KEY>>";
Sakticash_Config::$auth = base64_encode(Sakticash_Config::$usernameKey . ":" . Sakticash_Config::$passwordKey);

$isConnected = Sakticash_Merchant::isConnected();

if ($isConnected) {
    $trasaction_id = rand(11111111, 99999999);
    $data = [
        'amount' => rand(10000, 100000), // fill in the price of the item purchased
        'transaction_id' => $trasaction_id, // must unique on merchant and API server
        'transaction_datetime' => date('Y-m-d H:i:s'),
    ];

    var_dump(Sakticash_Merchant::createQRCode($data));

} else {
    var_dump($isConnected);
}
