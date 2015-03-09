@extends('themes.squadron.shell')

@section('head')

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')

    <title>@yield('title')</title>

    <!-- Styles -->
	<link href="/assets/css/bootswatch.css" rel="stylesheet">
	<link href="/assets/css/squadron-theme.css" rel="stylesheet">
	<!-- Fonts/icons -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	
	 <!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="/assets/js/squadron.js"></script>

    @yield('extra_styles')
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

@stop

@section('body')

    @yield('header')
    
    @yield('navbar')

    @yield('content')

    @yield('extra_scripts')

    <footer>
	    <div class="powered-by">
		    Powered by <a href="http://getsquadron.com">Squadron</a>
		</div>
		<div class="powered-by">
		    Powered by <a href="http://getsquadron.com">Squadron</a>
		</div>
    </footer>

@stop