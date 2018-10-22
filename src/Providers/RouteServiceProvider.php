<?php

namespace EliPett\ApiQueryLanguage\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::namespace('EliPett\ApiQueryLanguage\Controllers')
            ->prefix(config('apiquerylanguage.api_prefix', 'api'))
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
