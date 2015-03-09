@extends('themes.squadron.main')

@section('meta')
	@include('themes.squadron.clips.meta', ['seo' => $seo])
@endsection

@section('title')
	{{ $article->title }}
@endsection

@section('header')
	@include('themes.squadron.clips.header_slim')
@endsection

@section('navbar')
	@include('themes.squadron.clips.navbar', ['class' => 'slim'])
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<h1>{{ $article->title }}</h1>
			<p class="text-muted"><time pubdate datetime="{{ $article->created_at }}">{{ Carbon::parse($article->created_at)->toFormattedDateString() }}</time></p>
			<p class="lead">{{ $article->lead }}</p>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			{!! $content !!}
		</div>
	</div>
</div>
@endsection
