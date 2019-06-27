<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SaktiCash\Merchant;

$isConnected = Merchant::isConnected();

var_dump($isConnected);
