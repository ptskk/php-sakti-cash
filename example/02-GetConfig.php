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
    var_dump(Merchant::getConfig());
} else {
    var_dump($isConnected);
}
