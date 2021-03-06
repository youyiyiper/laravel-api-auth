<?php

namespace Qbhy\LaravelApiAuth;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $configSource = realpath(__DIR__ . '/config.php');
        $middlewareSource = realpath(__DIR__ . '/middleware.php');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                $middlewareSource => app_path('Http/Middleware/LaravelApiAuth.php'),
                $configSource => config_path('api_auth.php')
            ]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('api_auth');
        }
        $this->mergeConfigFrom($configSource, 'api_auth');
        $this->commands([
            Command::class,
        ]);
    }

}