<?php

/** @var Router $router */

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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Router;

$router->get(
    '/',
    function () use ($router) {
        return $router->app->version();
    }
);

$router->get(
    '/auth/check',
    [
        'middleware' => 'auth',
        function (Request $request, $id) {
            $user = Auth::user();
        },
    ]
);

$router->post('/auth/login', ['uses' => 'AuthController@login']);
$router->post('/auth/register', ['uses' => 'AuthController@register']);
$router->post('/auth/check', ['middleware' => 'auth', 'uses' => 'AuthController@check']);
