<?php

return [

	'cache' => [
		'enable' => false,
		'key' => 'LaravelNewsSitemap',
		'lifetime' => 60, // minutes
	],

	'defaults' => [
		'publication' => [
			'name' => null,
			'language' => null
		],
		'access' => null,
		'genres' => null,
		'keywords' => [],
		'stock_tickers' => []
	]

];
