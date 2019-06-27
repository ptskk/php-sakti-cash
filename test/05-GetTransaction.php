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
    // get history transaction on single date
    var_dump(Merchant::getTransactions('2019-06-20'));

    // get history transaction on single date with limit
    var_dump(Merchant::getTransactions('2019-06-20', null, 3));

    // get history transaction on between date
    var_dump(Merchant::getTransactions('2019-06-01', date('Y-m-d')));

    // get history transaction on between date with limit
    var_dump(Merchant::getTransactions('2019-06-01', date('Y-m-d'), 3));

} else {
    var_dump($isConnected);
}
