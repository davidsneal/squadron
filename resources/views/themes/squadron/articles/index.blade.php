@extends('themes.squadron.main')

@section('title')
{{ env('site_name') }}
@endsection

@section('header')
	@include('themes.squadron.clips.header_cropped', ['heading' => env('articles_index_heading')])
@endsection

@section('navbar')
	@include('themes.squadron.clips.navbar')
@endsection

@section('content')

<div class="container">
	@foreach($articles as $article)
		<div class="row">
	    	<article class="col-lg-10 col-lg-offset-1">
	        	<h1>{{ $article->title }}</h1>
	        	<p class="text-muted"><time pubdate datetime="{{ $article->created_at }}">{{ Carbon\Carbon::parse($article->created_at)->toFormattedDateString() }}</time></p>
				<p class="lead">{{ $article->lead }}</p>
				<a href="{{ $urls[$article->id] }}" class="btn btn-primary pull-right">Read more...</a>
	    	</article>
		</div>
	@endforeach
	<div class="text-center">
		{!! $articles->render() !!}
	</div>
</div>

@endsection
