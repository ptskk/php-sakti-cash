<?php
require_once('../Sakticash.php');

Sakticash_Config::$isProduction = false;
Sakticash_Config::$usernameKey = "<<CHANGE WITH YOUR MERCHANT USERNAME KEY>>";
Sakticash_Config::$passwordKey = "<<CHANGE WITH YOUR MERCHANT PASSWORD KEY>>";
Sakticash_Config::$auth = base64_encode(Sakticash_Config::$usernameKey . ":" . Sakticash_Config::$passwordKey);

$isConnected = Sakticash_Merchant::isConnected();

if ($isConnected) {
    // get history transaction on single date
    var_dump(Sakticash_Merchant::getTransactions('2019-06-20'));

    // get history transaction on single date with limit
    var_dump(Sakticash_Merchant::getTransactions('2019-06-20', null, 3));

    // get history transaction on between date
    var_dump(Sakticash_Merchant::getTransactions('2019-06-01', date('Y-m-d')));

    // get history transaction on between date with limit
    var_dump(Sakticash_Merchant::getTransactions('2019-06-01', date('Y-m-d'), 3));

} else {
    var_dump($isConnected);
}
