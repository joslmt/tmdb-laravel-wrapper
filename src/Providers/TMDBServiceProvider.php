<?php

namespace Josmlt\TMDBLaravelWrapper\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Josmlt\TMDBLaravelWrapper\Facades\TMDB;

class TMDBServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TMDB::class, function () {

            $client = new Client(
                [
                    'base_uri' => 'https://api.themoviedb.org/3/'
                ]
            );

            return new TMDB($client);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * php artisan vendor:publish --tag=tmdb
         */
        $this->publishes([
            __DIR__ . '/../config/tmdb.php' => config_path('tmdb.php')
        ],  'tmdb');
    }
}
