<?php

class NewsSitemapTest extends Orchestra\Testbench\TestCase {

	/**
	 * @var \Cviebrock\LaravelNewsSitemap\NewsSitemap
	 */
	protected $sitemap;

	protected function getPackageProviders() {
		return [
			'Cviebrock\LaravelNewsSitemap\ServiceProvider'
		];
	}

	public function setUp() {
		parent::setUp();

		$this->sitemap = $this->app->make('Cviebrock\LaravelNewsSitemap\NewsSitemap');

		$defaults = [
			'publication' => [
				'name' => 'Test News Site',
				'language' => 'en'
			],
			'access' => null,
			'genres' => null,
			'keywords' => [],
			'stock_tickers' => []
		];

		$this->sitemap->setDefaults($defaults);
	}

	public function testAddEntry() {

		$extras = [
			'keywords' => [
				'foo',
				'bar'
			]
		];

		$images = [
			['loc' => 'http://example.com/1.jpg'],
			['loc' => 'http://example.com/2.jpg'],
		];

		$this->sitemap->addEntry('http://example.com/', 'Example News Article', '2014-09-26T00:00:00+00:00', $extras, $images);

		$items = $this->sitemap->getEntries();

		$this->assertCount(1, $items);

		$item = $items[0];

		$this->assertEquals('http://example.com/', $item['loc']);

		$news = $item['news'];
		$this->assertEquals('2014-09-26T00:00:00+00:00', $news['publication_date']);
		$this->assertEquals('Example News Article', $news['title']);

		$publication = $news['publication'];
		$this->assertEquals('Test News Site', $publication['name']);
		$this->assertEquals('en', $publication['language']);

		$this->assertCount(2, $news['keywords']);
		$this->assertEquals($extras['keywords'], $news['keywords']);

		$images = $item['images'];
		$this->assertCount(2, $images);
		$this->assertEquals('http://example.com/1.jpg', $images[0]['loc']);
		$this->assertEquals('http://example.com/2.jpg', $images[1]['loc']);
	}

	public function testSitemapRender() {
		// TODO: finish this test
		// $data = $this->sitemap->render()
	}
}
