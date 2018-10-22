<?php

namespace EliPett\ApiQueryLanguage\Providers;

use Illuminate\Support\ServiceProvider;

class ApiQueryLanguageServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslations();
        $this->publishAssets();
    }

    private function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'apiquerylanguage');
    }

    private function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../config/apiquerylanguage.php' => config_path('apiquerylanguage.php'),
        ], 'config');
    }
}
