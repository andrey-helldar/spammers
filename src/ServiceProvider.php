<?php

namespace Helldar\Spammers;

use Helldar\Spammers\Commands\Amnesty;
use Helldar\Spammers\Commands\Delete;
use Helldar\Spammers\Commands\Exists;
use Helldar\Spammers\Commands\Restore;
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
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/spammers.php' => config_path('spammers.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Amnesty::class,
                Store::class,
                Delete::class,
                Restore::class,
                Exists::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/spammers.php', 'spammers'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/config/settings.php', 'spammers_settings'
        );
    }
}
