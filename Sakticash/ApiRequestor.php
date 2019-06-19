<?php

class Sakticash_ApiRequestor
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

        // merging with Sakticash_Config::$curlOptions
        if (count(Sakticash_Config::$curlOptions)) {
            // We need to combine headers manually, because it's array and it will no be merged
            if (Sakticash_Config::$curlOptions[CURLOPT_HTTPHEADER]) {
                $mergedHeders = array_merge($curl_options[CURLOPT_HTTPHEADER], Sakticash_Config::$curlOptions[CURLOPT_HTTPHEADER]);
                $headerOptions = array(CURLOPT_HTTPHEADER => $mergedHeders);
            } else {
                $mergedHeders = array();
            }

            $curl_options = array_replace_recursive($curl_options, Sakticash_Config::$curlOptions, $headerOptions);
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
                $result_array = json_decode($result);
            } catch (Exception $e) {
                throw new Exception("API Request Error unable to json_decode API response: " . $result . ' | Request url: ' . $url);
            }

            if (!in_array($result_array->status->response, array(200, 201, 202, 403))) {
                $message = 'Sakticash Error (' . $result_array->status->response . '): '
                    . $result_array->status->message . ': ' . json_encode($result_array->data);

                throw new Exception($message, $result_array->status->response);
            } else {
                return $result_array;
            }
        }
    }
}
