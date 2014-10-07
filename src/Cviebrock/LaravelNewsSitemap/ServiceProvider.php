<?php namespace Cviebrock\LaravelNewsSitemap;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot() {
		$this->package('cviebrock/laravel-news-sitemap', null, __DIR__.'/..');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {

		$this->app->bind('laravel-news-sitemap', function ($app) {
			$config = $app['config']->get('laravel-news-sitemap::config');
dd($config);
			return new NewsSitemap($config);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return array();
	}
}
