<?php

// Check PHP version.
if (version_compare(PHP_VERSION, '5.2.1', '<')) {
    throw new Exception('PHP version >= 5.2.1 required');
}

// Check PHP Curl & json decode capabilities.
if (!function_exists('curl_init') || !function_exists('curl_exec')) {
    throw new Exception('Sakti.cash needs the CURL PHP extension.');
}

if (!function_exists('json_decode')) {
    throw new Exception('Sakti.cash needs the JSON PHP extension.');
}

// Configurations
require_once('Sakticash/Config.php');
require_once('Sakticash/ApiRequestor.php');
require_once('Sakticash/Merchant.php');
require_once('Sakticash/Callback.php');
