<?php namespace Cviebrock\LaravelNewsSitemap;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

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
		$data = $this->buildXML();
		$headers = array('Content-type' => 'text/xml; charset=utf-8');

		return Response::make($data, 200, $headers);
	}


	protected function buildXML() {

		return View::make('news-sitemap::xml')
			->with('entries', $this->entries);

//		$xmlstr = file_get_contents(__DIR__ . '/../../stubs/news-sitemap.xml');
//		$map = new \SimpleXMLElement($xmlstr, LIBXML_NOBLANKS | LIBXML_COMPACT);
//
//
//		return $map->asXML();
	}

	public function isCached() {
		return false;
	}
}
