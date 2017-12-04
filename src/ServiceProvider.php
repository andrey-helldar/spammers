<?php

namespace Helldar\Spammers;

use Helldar\Spammers\Commands\Delete;
use Helldar\Spammers\Commands\Exists;
use Helldar\Spammers\Commands\Restore;
use Helldar\Spammers\Commands\Scan;
use Helldar\Spammers\Commands\Store;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/settings.php', 'spammers'
        );
    }

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/settings.php' => config_path('spammers.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Store::class,
                Delete::class,
                Restore::class,
                Exists::class,
                Scan::class,
            ]);
        }
    }
}
