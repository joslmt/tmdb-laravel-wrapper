<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400">
    </a>
    <a href="https://spoonacular.com/food-api" target="_blank">
        <img src="https://www.themoviedb.org/assets/2/v4/logos/v2/blue_square_2-d537fb228cf3ded904ef09b136fe3fec72548ebc1fea3fbbd1ad9e36364db38b.svg" width="200">
     </a>
</p>


# The Movie Database Laravel Wrapper 
This is a package develop with Laravel 8. It's a Laravel api wrapper to get info about movies, tv shows and more using TMDB Api and Laravel Facades.

## Steps to installation :memo:

It's necessary to be register in [The Movie Database](https://developers.themoviedb.org/3) and get a valid api key, it just take a moment.

### Package Locally Development :information_source:

We need to create a folder and within it we'll create a Laravel project and clone the repository. Structure similar to this : 

```
-- foo
    -- laravel_project
    -- package_laravel
```

After that, open `composer.json` file in our main Laravel project, add : 

```
 "require": {
     [. . .]
        "josmlt/tmdb-laravel-wrapper": "dev-master",
    }
"repositories": [
      {
          "type": "path",
          "url": "../tmdb-wrapper"
      }
    ],
```

Now require the package to the project, execute : 

```
composer require josmlt/tmdb-laravel-wrapper
```

Then execute, it will publish the config file :

```
php artisan vendor:publish --tag=tmdb
```

Finally we have two options, first we could have a default value of TMDB_KEY, within `config/tmdb.php` or as well we can add in our `.env` a new environment variable like `TMDB_KEY = ""`
    
### From Packagist :information_source:

```
composer require josmlt/tmdb-laravel-wrapper
```

Now we need to publish the config file :

```
php artisan vendor:publish --tag=tmdb
```

Finally we move into :
```
config/tmdb.php
```

And add our api key from [The Movie Database](https://developers.themoviedb.org/3), or alternative you can create a new environment variable named like `TMDB_KEY`.

## How to use it :question:

:point_right: Get top movies or tv shows.
```
\TMDB::getTop('tv', ['page' => 2]);
```

:point_right: Get more details about a specific movie, tv shows or an actor, set the last parameter to true and get available videos.
```
\TMDB::getDetails('movie', 3333, true);
```

:point_right: To search movies, tv shows and people use search method or searchAsync to do an asyncronus search, usefull when you have to send multiple request.
```
\TMDB::searchAsync('person', 'tom'));
```

## Testing :heavy_check_mark:

This package provides tests to get more confident using the package and check if it's possible to add a new feature without broke nothing valuable.

To execute tests : 
```
vendor/bin/phpunit tests/Unit/TMDBTest.php
```
![testingWrapper](https://user-images.githubusercontent.com/64318244/127705577-4ed8475f-c957-4f2e-b39a-fcc3f8ed65a7.PNG)
