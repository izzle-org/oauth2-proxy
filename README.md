# Izzle simple OAuth2 Proxy based on Laravel Lumen

## Usage

```php
<?php
use Illuminate\Support\Str;
use GuzzleHttp\Client;

const PROXY_BASE_URI = 'https://proxy.test';

session_start();

if (!empty($_REQUEST['state']) && !empty($_REQUEST['code'])) {
    if ($_SESSION['state'] !== $_REQUEST['state']) {
        die('Client: Invalid state');
    }
    
    $client = new Client();
    
    $response = $client->request('POST', PROXY_BASE_URI . '/token', [
        'verify' => false,
        'form_params' => [
            'code' => $_REQUEST['code']
        ]
    ]);
    
    echo json_decode((String) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    die();
}

$params = [
    'redirect_uri' => 'https://localhost/callback', // Your callback URL
    'state' => ($_SESSION['state'] = Str::random(40)),
    'scope' => 'profile phone'
];

header('Location: ' . PROXY_BASE_URI . '/redirect?' . http_build_query($params));
```

# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
