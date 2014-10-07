# laravel-news-sitemap

A Google News sitemap generator for Laravel 4.



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
$sitemap = \App::make('news-sitemap');

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
