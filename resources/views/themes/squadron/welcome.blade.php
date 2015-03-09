@extends('themes.squadron.main')

@section('title')
{{ Config::get('settings.site_name') }}
@endsection

@section('header')
	@include('themes.squadron.clips.header_large', ['heading' => $heading])
@endsection

@section('content')

<div class="container">
    <div class="page-header" id="banner">
    	<div class="row">
        	<div class="col-lg-8 col-md-7 col-sm-6">
            	<h1>Readable</h1>
				<p class="lead">Optimized for legibility</p>
          	</div>
    	</div>
	</div>
</div>

@endsection
