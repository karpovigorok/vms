<?php

namespace Arrilot\Api;

use Arrilot\Api\Generator\ApiMakeCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/config.php', 'laravel-api-generator'
        );

        $this->app->singleton('command.api.make', function ($app) {
            return new ApiMakeCommand($app['files']);
        });

        $this->commands('command.api.make');
    }

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('laravel-api-generator.php'),
        ]);

        require app_path(config('laravel-api-generator.routes_file'));
    }
}
