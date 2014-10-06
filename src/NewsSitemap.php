<?php namespace Cviebrock\LaravelNewsSitemap;

use Carbon\Carbon;
use Illuminate\Support\Arr;


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
		dd($this->entries);
	}


	public function isCached() {
		return false;
	}
}
