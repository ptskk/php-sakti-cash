<?php

namespace SaktiCash;

use Exception;

class Merchant
{
    public static function isConnected()
    {
        $url = Config::getBaseUrl() . "/check/connection";
        $connection = ApiRequestor::get($url, null, null);

        if ($connection->status->response === 200) {
            return true;
        } else {
            return false;
        }
    }

    public static function getConfig()
    {
        $url = Config::getBaseUrl() . "/check/config";
        $config = ApiRequestor::get($url, null, Config::$auth);
        return $config;
    }

    public static function createSign($json)
    {
        $method = "AES-256-CBC";
        $algorithm = "sha256";
        $key = hash($algorithm, md5(Config::$usernameKey));
        $iv = substr(hash($algorithm, md5(Config::$passwordKey)), 0, 16);
        return base64_encode(base64_encode(openssl_encrypt($json, $method, $key, 0, $iv)));
    }

    public static function createSignedData($data_hash)
    {
        if (is_array($data_hash)) {
            ksort($data_hash);
            $sign = self::createSign(json_encode($data_hash));
            $data_hash['signature'] = $sign;
            return $data_hash;
        } else {
            throw new Exception('data must be array');
        }
    }

    public static function createQRCode($data_hash)
    {
        $dataSigned = self::createSignedData($data_hash);
        $url = Config::getBaseUrl() . "/create/qrcode";
        return ApiRequestor::post($url, $dataSigned, Config::$auth);
    }

    public static function createWebTransaction($data_hash)
    {
        $dataSigned = self::createSignedData($data_hash);
        $url = Config::getBaseUrl() . "/create/wbt";
        return ApiRequestor::post($url, $dataSigned, Config::$auth);
    }

    public static function createSWebTransaction($data_hash)
    {
        $dataSigned = self::createSignedData($data_hash);
        $url = Config::getBaseUrl() . "/create/swbt";
        return ApiRequestor::post($url, $dataSigned, Config::$auth);
    }

    public static function createPushTransaction($data_hash)
    {
        $dataSigned = self::createSignedData($data_hash);
        $url = Config::getBaseUrl() . "/create/push";
        return ApiRequestor::post($url, $dataSigned, Config::$auth);
    }

    public static function checkStatus($transaction_id)
    {
        $url = Config::getBaseUrl() . "/check/status/" . $transaction_id;
        $status = ApiRequestor::get($url, null, Config::$auth);
        return $status;
    }

    public static function getTransactions($date, $to = null, $limit = 0)
    {
        $data_hash = array();
        $data_hash['date'] = $date;
        $data_hash['limit'] = $limit;

        if ($to <> null) {
            $data_hash['to'] = $to;
        }

        $dataSigned = self::createSignedData($data_hash);
        $url = Config::getBaseUrl() . "/get/transaction";
        return ApiRequestor::post($url, $dataSigned, Config::$auth);
    }

    public static function requestPermission($hp)
    {
        $data_hash = array();
        $data_hash['hp'] = $hp;

        $dataSigned = self::createSignedData($data_hash);
        $url = Config::getBaseUrl() . "/request/permission";
        return ApiRequestor::post($url, $dataSigned, Config::$auth);
    }

    public static function getPermission()
    {
        $url = Config::getBaseUrl() . "/get/permission";
        return ApiRequestor::get($url, null, Config::$auth);
    }

    public static function getCustomerInfo($hp)
    {
        $url = Config::getBaseUrl() . "/get/customer/" . $hp;
        return ApiRequestor::get($url, null, Config::$auth);
    }
}
