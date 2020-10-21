<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('redirect', ['uses' => 'ProxyController@redirect', 'as' => 'proxy.redirect']);
$router->post('token', ['uses' => 'ProxyController@token', 'as' => 'proxy.token']);
$router->get('callback', ['uses' => 'CallbackController@callback', 'as' => 'callback.callback']);
