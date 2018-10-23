<?php

namespace EliPett\ApiQueryLanguage\Providers;

use EliPett\ApiQueryLanguage\Services\ApiQueryLanguage;
use Illuminate\Support\ServiceProvider;

class ApiQueryLanguageServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslations();
        $this->publishAssets();
    }

    public function register()
    {
        $this->app->singleton(ApiQueryLanguage::class);
    }

    private function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'apiquerylanguage');
    }

    private function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../../config/apiquerylanguage.php' => config_path('apiquerylanguage.php'),
        ], 'config');
    }
}
