@extends('themes.squadron.main')

@section('title')
{{ $article->title }}
@endsection

@section('header')
	@include('themes.squadron.clips.header_slim')
@endsection

@section('content')
<div class="container">
  	<div class="page-header" id="banner">
    	<div class="row">
			<div class="col-lg-12">
				<h1>{{ $article->title }}</h1>
				<p class="lead">{{ $article->lead }}</p>
			</div>
    	</div>
  	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			{!! $content !!}
		</div>
	</div>
</div>
@endsection