<header class="image-bg-fixed-height">
	<div class="header-content">
		<div class="header-icon">
			<a href="/">
				<img src="{{ Config::get('settings.site_logo') }}" alt="{{ Config::get('settings.site_logo_alt') }}" />
			</a>
		</div>
		<div class="menu-icon">
			<span id="sqn-menu-toggle" class="sqn-menu-toggle glyphicon glyphicon-menu-hamburger"></span>
		</div>
		<div class="homepage-feature-title">
			<h1>{{ $heading }}</h1>
		</div>
	</div>
</header>