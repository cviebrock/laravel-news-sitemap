# laravel-news-sitemap

A Google News sitemap generator for Laravel 4.



## Installation

Add the package to your `composer.json` file:

```json
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
