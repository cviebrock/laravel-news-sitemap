<?php
namespace Cviebrock\LaravelNewsSitemap;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class NewsSitemap {

	protected $config;

	protected $entries = [];

	public function __construct($config) {
		$this->config = $config;
		dd($config);
	}


	public function addEntry($location, $title, $date, $extras = []) {

		$news = array_merge( $this->config['defaults'], $extras );
		$news['publication'] = array_merge( $this->config['defaults']['publication'], Arr::get('publication', $extras, []) );

		$news['title'] = $title;

		if ( is_int($date) ) {
			$date = Carbon::createFromTimeStamp( $date );
		} else if ( !($date instanceof Carbon) ) {
			$date = Carbon::parse($date);
		}

		$news['publication_date'] = $date->toW3cString();

		$this->entries[] = [
			'loc' => $location,
			'news' => $news
		];

	}


	public function render() {
		dd($this->entries);
	}

	public function isCached() {
		return false;
	}

}
