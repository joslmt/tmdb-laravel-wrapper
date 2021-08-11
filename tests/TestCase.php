<?php

namespace Josmlt\TMDBLaravelWrapper\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Default configuration I want to set, like TMDB_KEY for testing
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            'tmdb.tmdb_key',
            env('TMDB_KEY', '')
        );
    }

    /**
     * Get package providers.
     */
    protected function getPackageProviders($app)
    {
        return [
            'Josmlt\TMDBLaravelWrapper\Providers\TMDBServiceProvider'
        ];
    }

    /**
     * Get package aliases.
     */
    protected function getPackageAliases($app)
    {
        return [
            'TMDB' => 'Josmlt\TMDBLaravelWrapper\Facades\TMDBFacade'
        ];
    }
}
