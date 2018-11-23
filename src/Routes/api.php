<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router = app('router');

$router->post('/', [
    'uses' => 'QueryController@handle'
]);
