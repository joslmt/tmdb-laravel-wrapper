<?php

/*
|--------------------------------------------------------------------------
| Laravel Facade/Wrapper for The Movie Database API
|--------------------------------------------------------------------------
|
| In case you don't have an app key, it can be acquired from here :
|
| https://developers.themoviedb.org/3
|
*/

return [
    'tmdb_key' => env('TMDB_KEY', ''),

    'providers' => [
        /**
         * TMDB - The Movie Database
         */
        Josmlt\TMDBLaravelWrapper\Providers\TMDBServiceProvider::class,
    ],

    'aliases' => [
        /**
         * TMDB - The Movie Database
         */
        'TMDB' => Josmlt\TMDBLaravelWrapper\Facades\TMDBFacade::class,
    ]
];
