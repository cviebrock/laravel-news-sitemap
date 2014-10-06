<?php

return [
	'use_cache' => false,
	'cache_key' => 'newssitemap',
	'cache_duration' => 3600,

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
