<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router = app('router');

$router->group([
    'namespace' => 'EliPett\ApiQueryLanguage\Controllers',
    'middleware' => [],
    'prefix' => 'api'
], function(Router $router) {

    $router->post('query', [
        'uses' => 'ApiQueryController@query'
    ]);

});
