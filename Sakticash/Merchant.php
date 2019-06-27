<?php

class Sakticash_Merchant
{
    public function isConnected()
    {
        $url = Sakticash_Config::getBaseUrl() . "/check/connection";
        $connection = Sakticash_ApiRequestor::get($url, null, null);

        if ($connection->status->response === 200) {
            return true;
        } else {
            return false;
        }
    }

    public function getConfig()
    {
        $url = Sakticash_Config::getBaseUrl() . "/check/config";
        $config = Sakticash_ApiRequestor::get($url, null, Sakticash_Config::$auth);
        return $config;
    }

    public function createSign($json)
    {
        $method = "AES-256-CBC";
        $algorithm = "sha256";
        $key = hash($algorithm, md5(Sakticash_Config::$usernameKey));
        $iv = substr(hash($algorithm, md5(Sakticash_Config::$passwordKey)), 0, 16);
        return base64_encode(openssl_encrypt(base64_encode($json), $method, $key, 0, $iv));
    }

    public function createSignedData($data_hash)
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

    public function createQRCode($data_hash)
    {
        $dataSigned = Sakticash_Merchant::createSignedData($data_hash);
        $url = Sakticash_Config::getBaseUrl() . "/create/qrcode";
        return Sakticash_ApiRequestor::post($url, $dataSigned, Sakticash_Config::$auth);
    }

    public function createWebTransaction($data_hash)
    {
        $dataSigned = Sakticash_Merchant::createSignedData($data_hash);
        $url = Sakticash_Config::getBaseUrl() . "/create/wbt";
        return Sakticash_ApiRequestor::post($url, $dataSigned, Sakticash_Config::$auth);
    }

    public function checkStatus($transaction_id)
    {
        $url = Sakticash_Config::getBaseUrl() . "/check/status/" . $transaction_id;
        $status = Sakticash_ApiRequestor::get($url, null, Sakticash_Config::$auth);
        return $status;
    }

    public function getTransactions($date, $to = null, $limit = 0)
    {
        $data_hash = array();
        $data_hash['date'] = $date;
        $data_hash['limit'] = $limit;

        if ($to <> null) {
            $data_hash['to'] = $to;
        }

        $dataSigned = Sakticash_Merchant::createSignedData($data_hash);
        $url = Sakticash_Config::getBaseUrl() . "/get/transaction";
        return Sakticash_ApiRequestor::post($url, $dataSigned, Sakticash_Config::$auth);
    }
}
