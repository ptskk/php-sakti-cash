<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SaktiCash\Config;
use SaktiCash\Merchant;

Config::$isProduction = false;
Config::$usernameKey = "<<CHANGE WITH YOUR MERCHANT USERNAME KEY>>";
Config::$passwordKey = "<<CHANGE WITH YOUR MERCHANT PASSWORD KEY>>";
Config::$auth = base64_encode(Config::$usernameKey . ":" . Config::$passwordKey);

$isConnected = Merchant::isConnected();

if ($isConnected) {
    $trasaction_id = rand(11111111, 99999999);
    $data = [
        'amount' => rand(10000, 100000), // fill in the price of the item purchased
        'transaction_id' => $trasaction_id, // must unique on merchant and API server
        'transaction_datetime' => date('Y-m-d H:i:s'),
        'description' => 'beli a b c d e f g'
    ];

    var_dump(Merchant::createWebTransaction($data));

} else {
    var_dump($isConnected);
}
