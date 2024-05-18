<?php

namespace Alitindrawan24\RequestID;

use Illuminate\Support\ServiceProvider;

class RequestIDServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/request_id.php', 'request_id');
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/request_id.php' => config_path('request_id.php'),
            ], 'config');
        }
    }
}
