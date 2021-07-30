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
            env('TMDB_KEY', 'c946ac012e6ccfc95b990dbd6c9bc18d')
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
