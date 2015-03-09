<?php 
	
return [
	// core
	'site_name' 				=> 'Squadron', // The name of the website
	'admin_prefix' 				=> 'squadron', // Link to admin area
	'active_theme' 				=> 'squadron', // The theme active for the website
								
	// theme					
	'site_logo'					=> '/assets/img/squadron_icon_white.png', // The site logo
	'site_logo_alt'				=> 'Squadron Icon', // Alternative text for the site's logo
								
	// articles					
	'articles_index'			=> 'articles', // Listings page for articles, leaving this blank will result in it being used for the homepage
	'articles_index_heading'	=> 'Articles', // The heading shown on the articles index page
	'article_url_structure'		=> 'year/month/uri', // URL structure for viewing articles, appended with articles_index if set - 'year/month/uri' or 'uri'
	'articles_per_page'			=> 5, // The number of articles to show per page in the frontend
	'articles_per_page_admin'	=> 10, // The number of articles to show per page in the backend
];