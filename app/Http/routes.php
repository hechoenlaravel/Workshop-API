<?php
/** Rutas del API **/

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers'], function($api){
        $api->resource('users', 'UsersController');
    });
});
