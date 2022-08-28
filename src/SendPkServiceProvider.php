<?php

namespace MoeenBasra\SendPk;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class SendPkServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'send-pk');
        $this->mergeConfigFrom(__DIR__ . '/../config/send-pk.php', 'send-pk');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/send-pk.php' => config_path('send-pk.php')
            ], 'send-pk-config');

            $this->publishes([
                __DIR__ . '/../lang' => app()->langPath('send-pk'),
            ], 'send-pk-lang');
        }
    }

    public function register(): void
    {
        $this->app->singleton(
            'send-pk',
            fn($app) => new SendPk($app['config']['send-pk'])
        );
    }

    public function provides(): array
    {
        return [
            'send-pk',
            SendPk::class,
        ];
    }
}
