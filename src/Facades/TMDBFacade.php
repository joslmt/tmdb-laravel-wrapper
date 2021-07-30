<?php

namespace Josmlt\TMDBLaravelWrapper\Facades;

use Illuminate\Support\Facades\Facade;

class TMDBFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TMDB::class;
    }
}
