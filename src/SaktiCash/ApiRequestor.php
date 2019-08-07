<?php

namespace SaktiCash;

use Exception;

class ApiRequestor
{
    /**
     * Send GET request
     * @param string $url
     * @param string $auth
     * @param mixed[] $data_hash
     * @return mixed
     */
    public static function get($url, $data_hash, $auth)
    {
        return self::remoteCall($url, $data_hash, $auth, false);
    }

    /**
     * Send POST request
     * @param string $url
     * @param string $auth
     * @param mixed[] $data_hash
     * @return mixed
     */
    public static function post($url, $data_hash, $auth)
    {
        return self::remoteCall($url, $data_hash, $auth, true);
    }

    public static function remoteCall($url, $data_hash, $auth = null, $post = true)
    {
        $ch = curl_init();

        if ($auth) {
            $curl_options = array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Basic ' . $auth
                ),
                CURLOPT_RETURNTRANSFER => 1,
            );
        } else {
            $curl_options = array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                ),
                CURLOPT_RETURNTRANSFER => 1,

            );
        }

        // merging with Config::$curlOptions
        if (count(Config::$curlOptions)) {
            // We need to combine headers manually, because it's array and it will no be merged
            if (Config::$curlOptions[CURLOPT_HTTPHEADER]) {
                $mergedHeders = array_merge($curl_options[CURLOPT_HTTPHEADER], Config::$curlOptions[CURLOPT_HTTPHEADER]);
                $headerOptions = array(CURLOPT_HTTPHEADER => $mergedHeders);
            } else {
                $mergedHeders = array();
            }

            $curl_options = array_replace_recursive($curl_options, Config::$curlOptions, $headerOptions);
        }

        if ($post) {
            $curl_options[CURLOPT_POST] = 1;

            if ($data_hash) {
                $body = json_encode($data_hash);
                $curl_options[CURLOPT_POSTFIELDS] = $body;
            } else {
                $curl_options[CURLOPT_POSTFIELDS] = '';
            }
        }

        curl_setopt_array($ch, $curl_options);

        $result = curl_exec($ch);
        // curl_close($ch);

        if ($result === FALSE) {
            throw new Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
        } else {
            try {
                $header = json_decode(json_encode(curl_getinfo($ch)));
                $result_array = json_decode($result);
            } catch (Exception $e) {
                throw new Exception("API Request Error unable to json_decode API response: " . $result . ' | Request url: ' . $url);
            }

            if (!in_array($header->http_code, array(200, 201, 400, 401, 403, 503))) {
                $message = "API Request Error  response: " . $header->http_code . ' | Request url: ' . $url . ' | CURL Error:' . json_encode($header) . ' Response: ' . $result;
                throw new Exception($message);
            } else {
                return $result_array;
            }
        }
    }
}
