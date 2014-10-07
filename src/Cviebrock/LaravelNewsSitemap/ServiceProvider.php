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
		$this->package('cviebrock/laravel-news-sitemap', 'news-sitemap');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {

		$this->app->bind('Cviebrock\LaravelNewsSitemap\NewsSitemap', function ($app) {

			$sitemap = new NewsSitemap(
				$app['cache'],
				$app['view']
			);

			$sitemap->setUseCache($app['config']->get('news-sitemap::cache.enable'));
			$sitemap->setCacheKey($app['config']->get('news-sitemap::cache.key'));
			$sitemap->setCacheLifetime($app['config']->get('news-sitemap::cache.lifetime'));
			$sitemap->setDefaults($app['config']->get('news-sitemap::defaults'));

			return $sitemap;
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
