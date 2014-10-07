<?php namespace Cviebrock\LaravelNewsSitemap;

use Carbon\Carbon;
use Illuminate\Cache\CacheManager as Cache;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\View\Factory as View;


/**
 * Class NewsSitemap
 *
 * @package Cviebrock\LaravelNewsSitemap
 */
class NewsSitemap {

	/**
	 * @var array
	 */
	protected $entries = [];

	/**
	 * @var
	 */
	protected $useCache = false;

	/**
	 * @var
	 */
	protected $cacheKey = 'LaravelNewsSitemap';

	/**
	 * @var
	 */
	protected $cacheLifetime = 10;

	/**
	 * @var
	 */
	protected $defaults = [];

	/**
	 * @var Cache
	 */
	private $cache;

	/**
	 * @var View
	 */
	private $view;

	/**
	 * @param Cache $cache
	 * @param View $view
	 */
	public function __construct(Cache $cache, View $view) {
		$this->cache = $cache;
		$this->view = $view;
	}

	/**
	 * @return mixed
	 */
	public function getCacheKey() {
		return $this->cacheKey;
	}

	/**
	 * @param mixed $cacheKey
	 */
	public function setCacheKey($cacheKey) {
		$this->cacheKey = $cacheKey;
	}

	/**
	 * @return mixed
	 */
	public function getCacheLifetime() {
		return $this->cacheLifetime;
	}

	/**
	 * @param mixed $cacheLifetime
	 */
	public function setCacheLifetime($cacheLifetime) {
		$this->cacheLifetime = $cacheLifetime;
	}

	/**
	 * @return mixed
	 */
	public function getDefaults() {
		return $this->defaultValues;
	}

	/**
	 * @param mixed $defaultValues
	 */
	public function setDefaults($defaultValues) {
		$this->defaultValues = $defaultValues;
	}

	/**
	 * @return mixed
	 */
	public function getUseCache() {
		return $this->useCache;
	}

	/**
	 * @param mixed $useCache
	 */
	public function setUseCache($useCache) {
		$this->useCache = $useCache;
	}

	/**
	 * @param $location
	 * @param $title
	 * @param $date
	 * @param array $extras
	 * @param array $images
	 */
	public function addEntry($location, $title, $date, $extras = [], $images = []) {

		$news = array_merge(
			$this->getDefaults(),
			$extras
		);

		$news['publication'] = array_merge(
			Arr::get($this->getDefaults(), 'publication', []),
			Arr::get($extras, 'publication', [])
		);

		$news['title'] = $title;

		if (is_int($date)) {
			$date = Carbon::createFromTimeStamp($date);
		} else if (!($date instanceof Carbon)) {
			$date = Carbon::parse($date);
		}

		$news['publication_date'] = $date->toW3cString();

		$this->entries[] = [
			'loc' => $location,
			'news' => $news,
			'images' => $images,
		];
	}


	/**
	 * @return \Illuminate\Http\Response
	 */
	public function render() {
		if ($this->getUseCache()) {
			$data = $this->cache->remember($this->getCacheKey(), $this->getCacheLifetime(), function () {
				return $this->buildXML();
			});
		} else {
			$data = $this->buildXML();
		}

		$headers = ['Content-type' => 'text/xml; charset=utf-8'];

		return new Response($data, 200, $headers);
	}

	/**
	 * @return bool
	 */
	public function isCached() {
		return $this->getUseCache() && $this->cache->has($this->getCacheKey());
	}

	/**
	 * @return array
	 */
	public function getEntries() {
		return $this->entries;
	}

	/**
	 * @return string
	 */
	protected function buildXML() {

		return $this->view->make('news-sitemap::xml')
			->with('entries', $this->entries)
			->render();
	}
}
