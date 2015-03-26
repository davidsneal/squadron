<?php 
	
return [
	// core
	'site_name' 					=> 'Squadron', // The name of the website
	'admin_prefix' 					=> 'squadron', // Link to admin area
	'active_theme' 					=> 'squadron', // The active theme for the frontend
									
	// users						
	'allow_public_registration' 	=> true, // allow users to signup to your website
	'new_register_redirect' 		=> '/', // the url to redirect newly registered users to
	'non_admin_login_redirect' 		=> '/', // the url to redirect newly registered users to
									
	// asset management				
	'asset_upload_directory'		=> '/assets/uploads/', // within public directory, with leading and trailing slashes
	'asset_accepted_extensions'		=> [
		'jpg', 'jpeg', 'png', 'gif', 'pdf', 'csv', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'ods'
	], // an array of accepted file extensionsassets/js/squadron-admin.js too
	'asset_max_filesize'			=> 50000, // the maximum filesize in kb to accept, you may need to check your PHP settings
									
	// theme						
	'site_logo'						=> '/assets/img/squadron_icon_white.png', // The site logo
	'site_logo_alt'					=> 'Squadron Icon', // Alternative text for the site's logo
									
	// articles						
	'articles_index'				=> 'articles', // Listings page for articles, leaving this blank will result in it being used for the homepage
	'articles_index_heading'		=> 'Articles', // The heading shown on the articles index page
	'article_url_structure'			=> '{year}/{month}/{uri}', // URL structure for viewing articles, appended with articles_index if set - '{year}/{month}/{uri}' or '{uri'
	'articles_per_page'				=> 5, // The number of articles to show per page in the frontend
	'articles_per_page_admin'		=> 10, // The number of articles to show per page in the backend
];