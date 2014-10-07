# laravel-news-sitemap

A Google News sitemap generator for Laravel 4.

[![Build Status](https://travis-ci.org/cviebrock/eloquent-sluggable.svg)](https://travis-ci.org/cviebrock/laravel-news-sitemap)
[![Total Downloads](https://poser.pugx.org/cviebrock/laravel-news-sitemap/downloads.png)](https://packagist.org/packages/cviebrock/laravel-news-sitemap)
[![Latest Stable Version](https://poser.pugx.org/cviebrock/laravel-news-sitemap/v/stable.png)](https://packagist.org/packages/cviebrock/laravel-news-sitemap)



## Installation

Add the package to your `composer.json` file:

```
'cviebrock/laravel-news-sitemap' => 'dev-master'
```

Add the service provider to `app/config/app.php`

```php
'providers' => array(
    ...
    'Cviebrock\LaravelNewsSitemap\ServiceProvider',
);
```

Publish the configuration file:

```sh
php artisan config:publish cviebrock/laravel-news-sitemap
```



## Sample Usage

```php
// create a new sitemap instance
$sitemap = \App::make('Cviebrock\LaravelNewsSitemap\NewsSitemap');

// if it's not cached, then populate with entries
if (!$sitemap->isCached()) {

    foreach (Posts::all() as $post) {

		$extras = [];
		$images = [];

		foreach ($post->images as $image) {
			$images[] = [
			    'loc' => $image->url,
			    'caption' => $image->caption
            ];
		}

		$extras['keywords'] = $post->topics->lists('name');

		$this->sitemap->addEntry($post->url, $post->title, $post->published_at, $extras, $images);
	}

}

// returns an XML response
return $sitemap->render();
```



## Bugs, Suggestions and Contributions

Please use Github for bugs, comments, suggestions.

1. Fork the project.
2. Create your bugfix/feature branch and write your (well-commented) code.
3. Commit your changes and push to your repository.
4. Create a new pull request against this project's `master` branch.



## Copyright and License

**laravel-news-sitemap** was written by Colin Viebrock and released under the MIT License. See the LICENSE file for details.

Copyright 2014 Colin Viebrock
