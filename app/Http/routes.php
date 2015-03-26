<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// patterns
Route::pattern('year', '[0-9]{4}');
Route::pattern('month', '[0-9]{2}');

// homepage
Route::get('/', 'WelcomeController@index');

// articles section (if a prefix is set)
Route::group(array('prefix' => Config::get('settings.articles_index')), function()
{
	// article index
	Route::get('', 'ArticleController@FE_index');

	// switch based on article_url_structure
	switch(Config::get('settings.article_url_structure'))
	{
		case '{year}/{month}/{uri}':
		default:
			Route::get('{year}/{month}/{uri}', 'ArticleController@show_YMU');
		break;
		
		case '{uri}':
			Route::get('{uri}', 'ArticleController@show_U');
		break;
	}
});

// admin sections/actions
Route::group(array('prefix' => Config::get('settings.admin_prefix')), function()
{
	// authed users only
	Route::group(['middleware' => ['auth', 'admin']], function()
	{
		// squadron base
		Route::get('', 'SquadronController@index');
		
		// assets sections/actions
		Route::group(array('prefix' => 'assets'), function()
		{
			Route::get('', 					'AssetsFolderController@index');
			Route::get('folder/{id}', 		'AssetsFolderController@show');
			Route::post('folder/create', 	'AssetsFolderController@create');
			Route::post('asset/create', 	'AssetController@create');
		});
		
		// articles sections/actions
		Route::group(array('prefix' => 'articles'), function()
		{
			Route::get('', 					'ArticleController@index');
			Route::get('edit/{id?}', 		'ArticleController@edit');
			Route::post('create', 			'ArticleController@create');
		});
	});
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);