<?php

namespace SaktiCash;

// Check PHP version.
use Exception;

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
require_once('SaktiCash/Config.php');
require_once('SaktiCash/ApiRequestor.php');
require_once('SaktiCash/Merchant.php');
require_once('SaktiCash/Callback.php');
