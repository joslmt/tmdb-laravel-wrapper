<?php

namespace Josmlt\TMDBLaravelWrapper\Facades;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;

/**
 * Wrapp all Facade logic. Make requests to themoviedb API returning an object 
 * or an array of data.
 * 
 * @see https://developers.themoviedb.org/3/getting-started/introduction
 * 
 * @author Jose <joseluis95123@gmail.com>
 */
class TMDB
{
    /**
     * Custom Guzzle Client object.
     *
     * @var object
     */
    protected $client;

    /**
     * DI of Client Guzzle class.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get data about the specify endpoint. 
     * 
     * Build a specific request using query option (Guzzle).
     * @see https://docs.guzzlephp.org/en/stable/request-options.html?highlight=query 
     * 
     * @param string $endpoint Where request will be send.
     * @param array $query Asociative array of data.
     * 
     * @return object|array Request data.
     */
    private function getData(string $endpoint, array $query = null): object|array
    {
        $api_key = ['api_key' => config('tmdb.tmdb_key', '')];

        $query == null ? $queryParameters = $api_key : $queryParameters = array_merge($api_key, $query);

        return json_decode(
            $this->client
                ->get($endpoint, ['query' => $queryParameters])
                ->getBody()
        );
    }

    /**
     * Get top rated movies or tv series.
     * 
     * @param string $type This can be 'tv' or 'movie'
     * @param string|array $information A single string of information or an 
     * associative array to do a more complex search, e.g = page number, region 
     * or language
     * 
     * @return object Information found it.
     *  
     * @see https://developers.themoviedb.org/3/movies/get-top-rated-movies
     * @see https://developers.themoviedb.org/3/tv/get-top-rated-tv
     */
    public function getTop(string $type, string|array $information = null): object
    {
        if (!is_array($information)) {
            return $this->getData("{$type}/top_rated", ['query' => $information]);
        }
        return $this->getData("{$type}/top_rated", $information);
    }

    /**
     * Get details about a specific movie, tv serie or person, if videos 
     * parameter is set to true the request also get available videos.
     *
     * @param string $type This can be 'tv' or 'movie' or 'person'.
     * @param int $id movie_id, tv_id The unique identifation.
     * @param boolean $videos Get videos if is set to true.
     * 
     * @return object Information found it.
     * 
     * @see https://developers.themoviedb.org/3/movies/get-movie-details
     * @see https://developers.themoviedb.org/3/tv/get-tv-details 
     * @see https://developers.themoviedb.org/3/people/get-person-details 
     */
    public function getDetails(string $type, int $id, bool $videos = false): object
    {
        if ($videos) {
            return $this->getData("{$type}/{$id}", ['append_to_response' => 'videos']);
        }
        return $this->getData("{$type}/{$id}");
    }

    /**
     * Search information about movies, tv shows or people.
     *
     * @param string $type This can be 'tv' or 'movie' or 'person'.
     * @param string $query What movie, tv o who person.
     * @param int $page Number of page to search. By default start in the first 
     * page.
     * @param bool $adult_content Set to true no enable adult content.
     * 
     * @return object Information found it.
     * 
     * @see https://developers.themoviedb.org/3/search/search-movies
     * @see https://developers.themoviedb.org/3/search/search-people
     * @see https://developers.themoviedb.org/3/search/search-tv-shows
     */
    public function search(string $type, string $query, int $page = 1, bool $adult_content = false): object
    {
        return $this->getData(
            "search/{$type}?",
            [
                'query' => $query,
                'include_adult' => $adult_content,
                'page' => $page
            ]
        );
    }

    /**
     * Search information about movies, tv shows or people. 
     * Usefull to get all searched results using a loop to fetch results page 
     * per page.
     *
     * @param string $type This can be 'tv' or 'movie' or 'person'.
     * @param string $query What movie, tv o who person.
     * @param int $page Number of page to search. By default start in the first 
     * page.
     * @param bool $include_adult Set to true no enable adult content.
     * @param int $total Number of total async request to do.
     * @param int $concurrency Number of simultaneous request.
     * 
     * @return array Information found it.
     * 
     * @see https://developers.themoviedb.org/3/search/search-movies
     * @see https://developers.themoviedb.org/3/search/search-people
     * @see https://developers.themoviedb.org/3/search/search-tv-shows
     * @see Pool : https://docs.guzzlephp.org/en/stable/quickstart.html 
     */
    public function searchAsync(string $type, string $query, int $page = 1, bool $include_adult = false, int $total = 100, int $concurrency = 10): array
    {
        $client =  $this->client;

        $requests = function ($total) use ($client, $type, $query, $include_adult, $page) {

            $uri = "search/{$type}?" . "api_key=" . config('tmdb.tmdb_key') . "&query={$query}&page={$page}&include_adult={$include_adult}";
            for ($i = 0; $i < $total; $i++) {
                yield function () use ($client, $uri) {
                    return $client->getAsync($uri);
                };
            }
        };

        /**
         * Array of request data.
         * 
         * @var array 
         */
        $data = [];

        $pool = new Pool($client, $requests($total), [
            'concurrency' => $concurrency,
            'fulfilled' => function (Response $response) use (&$data) {
                $data = json_decode($response->getBody())->results;
            },
            'rejected' => function (RequestException $reason) {
                $reason->getCode() . ' ' . $reason->getMessage();
            },
        ]);

        $promise = $pool->promise();

        try {
            $promise->wait();
        } catch (\Throwable $th) {
            $th->getMessage();
        }

        return $data;
    }
}
