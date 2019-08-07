<?php

namespace SaktiCash;

/**
 * Sakticash Configuration
 */
class Config
{

    /**
     * Your merchant's username key
     * @static
     */
    public static $usernameKey;

    /**
     * Your merchant's password key
     * @static
     */
    public static $passwordKey;


    /**
     * Your merchant's auth
     * @static
     */
    public static $auth;


    /**
     * true for production
     * false for sandbox mode
     * @static
     */
    public static $isProduction = false;

    /**
     * Default options for every request
     * @static
     */
    public static $curlOptions = array();

    const SANDBOX_BASE_URL = 'https://dev-sc.mycoop.id/api';
    const PRODUCTION_BASE_URL = 'https://sc.mycoop.id/api';


    /**
     * @return string Sakticash API URL, depends on $isProduction
     */
    public static function getBaseUrl()
    {
        return self::$isProduction ?
            self::PRODUCTION_BASE_URL : self::SANDBOX_BASE_URL;
    }
}
