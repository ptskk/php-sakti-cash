SAKTI.Cash PHP Library
==

Sakti.Cash :heart: PHP!

This is Official PHP wrapper/library for Sakti.Cash Payment Gateway. Visit [http://sc.mycoop.id](http://sc.mycoop.id) for more information about the product.

## General Settings
```

// set true for production use
Sakticash_Config::$isProduction = false;

// your api_username obtained from merchant dashboard
Sakticash_Config::$usernameKey = "SzIvUmM2-bGkzWGdG-WmVES1lZ-bE14aldQ-VExtODNM-SlNpMXY5-OXRzay93-MD0=";

// your api_password obtained from merchant dashboard
Sakticash_Config::$passwordKey = "YUtWRE00-YWUrRGtY-bHJxMnFV-cVpXakdC-U1FoT3JZ-RWhHdkd4-cEtGVmN5-VT0=";
// this for Basic Auth
Sakticash_Config::$auth = base64_encode(Sakticash_Config::$usernameKey . ":" . Sakticash_Config::$passwordKey);
```
## Example
See `Example` directory