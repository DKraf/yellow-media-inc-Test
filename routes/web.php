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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/'], function ($app) {
    $app->group(['prefix' => 'user/'], function ($user) {
        $user->post('sign-in',          'AuthController@login');
        $user->post('recover-password', 'AuthController@recoverPassword');
        $user->post('reset-password',   [ 'as' => 'password.reset', 'uses' => 'AuthController@resetPassword']);
        $user->post('register',         'UserController@store');
        $user->get('companies',         ['middleware' => 'auth', 'uses' => 'CompanyController@list']);
        $user->post('companies',        ['middleware' => 'auth', 'uses' => 'CompanyController@store']);
        $user->post('logout',           ['middleware' => 'auth', 'uses' => 'AuthController@logout']);
    });
});
