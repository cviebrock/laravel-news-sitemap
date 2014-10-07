<?php namespace Cviebrock\LaravelNewsSitemap;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Cache;
use Response;
use View;


class NewsSitemap {

	protected $config;

	protected $entries = [];


	public function __construct($config) {
		$this->config = $config;
	}


	public function addEntry($location, $title, $date, $extras = [], $images = []) {

		$news = array_merge(
			Arr::get($this->config, 'defaults', []),
			$extras
		);

		$news['publication'] = array_merge(
			Arr::get($this->config, 'defaults.publication', []),
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


	public function render() {
		if ($this->useCache()) {
			$data = Cache::remember($this->cacheKey(), $this->cacheLifetime(), function () {
				return $this->buildXML();
			});
		} else {
			$data = $this->buildXML();
		}

		$headers = ['Content-type' => 'text/xml; charset=utf-8'];

		return Response::make($data, 200, $headers);
	}


	protected function buildXML() {

		return View::make('news-sitemap::xml')
			->with('entries', $this->entries)
			->render();
	}

	public function isCached() {
		return $this->useCache() && Cache::has($this->cacheKey());
	}

	public function getEntries() {
		return $this->entries;
	}

	protected function useCache() {
		return Arr::get($this->config, 'cache.enable');
	}

	protected function cacheKey() {
		return Arr::get($this->config, 'cache.key');
	}

	protected function cacheLifetime() {
		return Arr::get($this->config, 'cache.lifetime');
	}
}
