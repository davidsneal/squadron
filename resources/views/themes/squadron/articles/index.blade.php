@extends('themes.squadron.main')

@section('title')
{{ Config::get('settings.site_name') }}
@endsection

@section('header')
	@include('themes.squadron.clips.header_cropped', ['heading' => Config::get('settings.articles_index_heading')])
@endsection

@section('content')

<div class="container">
	@foreach($articles as $article)
		<div class="row">
	    	<article class="col-lg-10 col-lg-offset-1">
	        	<h1>{{ $article->title }}</h1>
	        	<p class="text-muted">{{ Carbon::parse($article->created_at)->toFormattedDateString() }}</p>
				<p class="lead">{{ $article->lead }}</p>
				<a href="#" class="btn btn-primary pull-right">Read more...</a>
	    	</article>
		</div>
	@endforeach
</div>

@endsection
