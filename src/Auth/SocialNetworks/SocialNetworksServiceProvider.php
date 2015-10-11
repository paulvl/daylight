<?php

namespace Daylight\Auth\SocialNetworks;

use Illuminate\Support\ServiceProvider;
use Daylight\Auth\Console\DaylightPublishMigrationsCommand;

class SocialNetworksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->publishes([
        //     __DIR__.'/../config/package.php' => config_path('package.php')
        // ], 'config');

        $this->publishes([
            __DIR__.'/../../../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDaylightPublishMigrationsCommand();
    }

         /**
    * Register the auth:clear-confirmations command.
    */
    private function registerDaylightPublishMigrationsCommand()
    {
        $this->app->singleton('command.daylight.publish.migrations', function ($app) {
            return $app[DaylightPublishMigrationsCommand::class];
        });
        $this->commands('command.daylight.publish.migrations');
    }
}
