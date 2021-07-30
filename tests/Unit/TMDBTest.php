<?php

namespace Josmlt\TMDBLaravelWrapper\Tests\Unit;

use Josmlt\TMDBLaravelWrapper\Tests\TestCase;

class TMDBTest extends TestCase
{
    /**
     * @test
     */
    public function return_an_object_of_toprated_movies()
    {
        $tmdb = \TMDB::getTop('movie', ['page' => 5]);
        $this->assertIsObject($tmdb);
        $this->assertObjectHasAttribute('title', $tmdb->results[0]);
        $this->assertObjectHasAttribute('poster_path', $tmdb->results[0]);
        $this->assertObjectHasAttribute('overview', $tmdb->results[0]);
    }

    /**
     * @test 
     */
    public function return_an_object_of_toprated_tvshows()
    {
        $tmdb = \TMDB::getTop('tv', ['page' => 10]);
        $this->assertIsObject($tmdb);
        $this->assertObjectHasAttribute('name', $tmdb->results[0]);
        $this->assertObjectHasAttribute('poster_path', $tmdb->results[0]);
        $this->assertObjectHasAttribute('overview', $tmdb->results[0]);
    }

    /**
     * @test
     */
    public function return_an_object_of_movies_tvshows_or_people_with_details_and_available_videos_if_third_parameter_is_true()
    {
        $tmdb = \TMDB::getDetails('movie', 157336, true);
        $this->assertIsObject($tmdb);
        $this->assertObjectHasAttribute('title', $tmdb);
        $this->assertObjectHasAttribute('tagline', $tmdb);
        $this->assertObjectHasAttribute('poster_path', $tmdb);
        $this->assertObjectHasAttribute('videos', $tmdb);
    }

    /**
     * @test
     */
    public function return_an_object_of_movies_tvshows_or_people_with_details_not_return_videos()
    {
        $tmdb = \TMDB::getDetails('movie', 157336);
        $this->assertIsObject($tmdb);
        $this->assertObjectHasAttribute('title', $tmdb);
        $this->assertObjectHasAttribute('tagline', $tmdb);
        $this->assertObjectHasAttribute('poster_path', $tmdb);
        $this->assertObjectNotHasAttribute('videos', $tmdb);
    }

    /**
     * @test
     */
    public function return_an_object_of_movies_found()
    {
        $tmdb = \TMDB::search('movie', 'peace', 1);
        $this->assertIsObject($tmdb);
        $this->assertObjectHasAttribute('title', $tmdb->results[0]);
        $this->assertObjectHasAttribute('poster_path', $tmdb->results[0]);
        $this->assertObjectHasAttribute('overview', $tmdb->results[0]);
    }

    /**
     * @test 
     */
    public function return_an_object_of_tvshows_found()
    {
        $tmdb = \TMDB::search('tv', 'girls');
        $this->assertIsObject($tmdb);
        $this->assertObjectHasAttribute('name', $tmdb->results[0]);
        $this->assertObjectHasAttribute('poster_path', $tmdb->results[0]);
        $this->assertObjectHasAttribute('overview', $tmdb->results[0]);
    }

    /**
     * @test 
     */
    public function return_an_object_of_people_found()
    {
        $tmdb = \TMDB::search('person', 'Tom');
        $this->assertIsObject($tmdb);
        $this->assertObjectHasAttribute('name', $tmdb->results[0]);
        $this->assertObjectHasAttribute('profile_path', $tmdb->results[0]);
        $this->assertObjectHasAttribute('known_for', $tmdb->results[0]);
    }

    /**
     * @test 
     */
    public function search_with_pool_and_return_an_object_of_people_found()
    {
        $tmdb = \TMDB::searchAsync('person', 'Tom');
        $this->assertIsArray($tmdb);
        $this->assertObjectHasAttribute('name', $tmdb[0]);
        $this->assertObjectHasAttribute('profile_path', $tmdb[0]);
        $this->assertObjectHasAttribute('known_for', $tmdb[0]);
    }
}
