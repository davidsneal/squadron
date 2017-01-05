<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ env('site_name') }}</title>
	
	<!-- Fonts/Icons -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<!-- Styles -->
	<link href="{{ asset('css/bootswatch.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-markdown.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/fileinput.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/squadron-admin.css') }}" rel="stylesheet">

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap-markdown.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/markdown.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/fileinput.min.js') }}"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">{{ env('site_name') }}</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="/{{ env('admin_prefix', 'admin') }}">Base</a></li>
					<li><a href="/{{ env('admin_prefix', 'admin') }}/assets">Assets</a></li>
					<li><a href="/{{ env('admin_prefix', 'admin') }}/articles">Articles</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if(Auth::guest())
						<li><a href="/auth/login">Login</a></li>
						@if(env('allow_public_registration'))
							<li><a href="/auth/register">Register</a></li>
						@endif
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/auth/logout">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')
	
	<!-- Alert div ready if needed -->
    <div id="custom-alert" class="custom-alert alert">
      <span id="alert-content"></span>
    </div>
    
    <!-- powered by -->
    <div class="powered-by">
      Powered by <a href="http://getsquadron.com" title="Squadron">Squadron</a>
    </div>
    
	<!-- extra scripts -->
	<script type="text/javascript" src="{{ asset('js/squadron-admin.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/validator.js') }}"></script>

</body>
</html>
