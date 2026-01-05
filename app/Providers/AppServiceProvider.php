<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\MetadadosProviderInterface;
use App\Adapters\ApiFootball\ApiFootballMetadadosAdapter;
use App\Adapters\Mock\MockMetadadosAdapter;
use App\Contracts\HistoricoH2HProviderInterface;
use App\Adapters\Mock\MockHistoricoH2HAdapter;
use App\Contracts\OddsProviderInterface;
use App\Adapters\Mock\MockOddsAdapter;
use App\Adapters\ApiFootball\ApiFootballOddsAdapter;
use App\Contracts\ArbitragemProviderInterface;
use App\Adapters\Mock\MockArbitragemAdapter;
use App\Adapters\ApiFootball\ApiFootballArbitragemAdapter;
use App\Contracts\TimeProviderInterface;
use App\Adapters\ApiFootball\ApiFootballTimeAdapter;
use App\Adapters\Mock\MockTimeAdapter;

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
            $this->app->bind(
                HistoricoH2HProviderInterface::class,
                MockHistoricoH2HAdapter::class
            );
            $this->app->bind(
                MetadadosProviderInterface::class,
                MockMetadadosAdapter::class
            );
            $this->app->bind(
                OddsProviderInterface::class,
                MockOddsAdapter::class
            );
            $this->app->bind(
                ArbitragemProviderInterface::class,
                MockArbitragemAdapter::class
            );
            $this->app->bind(
                TimeProviderInterface::class,
                MockTimeAdapter::class
            );

        } else {

            $this->app->bind(
                MetadadosProviderInterface::class,
                ApiFootballMetadadosAdapter::class
            );
            $this->app->bind(
                HistoricoH2HProviderInterface::class,
                ApiFootballHistoricoH2HAdapter::class
            );
            $this->app->bind(
                OddsProviderInterface::class,
                ApiFootballOddsAdapter::class
            );
            $this->app->bind(
                ArbitragemProviderInterface::class,
                ApiFootballArbitragemAdapter::class
            );
            $this->app->bind(
                TimeProviderInterface::class,
                ApiFootballTimeAdapter::class
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
