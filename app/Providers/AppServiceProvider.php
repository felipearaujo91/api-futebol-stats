<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\MetadadosProviderInterface;
use App\Adapters\ApiFootball\ApiFootballMetadadosAdapter;
use App\Adapters\Mock\MockMetadadosAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         if (config('app.env') === 'local') {
            $this->app->bind(
                MetadadosProviderInterface::class,
                MockMetadadosAdapter::class
            );
        } else {
            $this->app->bind(
                MetadadosProviderInterface::class,
                ApiFootballMetadadosAdapter::class
            );
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
