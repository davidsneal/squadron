<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<!-- Styles -->
	<link href="/assets/css/bootswatch.css" rel="stylesheet">
	<link href="/assets/css/squadron.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="sqn-menu-push">

<nav class="sqn-menu" id="sqn-menu">
	<a href="#">Celery seakale</a>
</nav>


	<header class="image-bg-fluid-height">
		<div class="header-content">
			<div class="header-icon">
				<a href="/">
					<img src="/assets/img/squadron_icon_white.png" alt="Squadron Icon" />
				</a>
			</div>
			<div class="menu-icon">
				<span id="sqn-menu-toggle" class="sqn-menu-toggle glyphicon glyphicon-menu-hamburger"></span>
			</div>
			<div class="homepage-feature-title">
				<h1>Squadron</h1>
			</div>
		</div>
    </header>
	
	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="/assets/js/classie.js"></script>
	<script src="/assets/js/squadron.js"></script>
</body>
</html>
