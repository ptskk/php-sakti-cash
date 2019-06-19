<?php
require_once('../Sakticash.php');

$isConnected = Sakticash_Merchant::isConnected();

var_dump($isConnected);
