{{ '<' . '?' . 'xml version="1.0" encoding="UTF-8"' . '?' . '>' }}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
 xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
 xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
>
@foreach($entries as $entry)
<url>
	<loc>{{ $entry['loc'] }}</loc>
	<news:news>
		<news:publication>
			<news:name>{{ $entry['news']['publication']['name'] }}</news:name>
			<news:language>{{ $entry['news']['publication']['language'] }}</news:language>
		</news:publication>
		@if($entry['news']['access'])
		<news:access>{{ $entry['news']['access'] }}</news:access>
		@endif
		@if(count($entry['news']['genres']))
		<news:genres>{{ join(', ', $entry['news']['genres']) }}</news:genres>
		@endif
		<news:publication_date>{{ $entry['news']['publication_date'] }}</news:publication_date>
		<news:title>{{ $entry['news']['title'] }}</news:title>
		@if(count($entry['news']['keywords']))
		<news:keywords>{{ join(', ', $entry['news']['keywords']) }}</news:keywords>
		@endif
		@if(count($entry['news']['stock_tickers']))
		<news:stock_tickers>{{ join(', ', $entry['news']['stock_tickers']) }}</news:stock_tickers>
		@endif
	</news:news>
	@foreach($entry['images'] as $image)
	<image:image>
		<image:loc>{{ $image['loc'] }}</image:loc>
		@if($image['caption'])
		<image:caption>{{ $image['caption'] }}</image:caption>
		@endif
	</image:image>
	@endforeach
</url>
@endforeach
</urlset>
