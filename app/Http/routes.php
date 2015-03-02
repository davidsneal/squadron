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

Route::get('/', 'WelcomeController@index');

Route::get('{year}/{month}/{uri}', 'ArticleController@show');

// admin sections/actions
Route::group(array('prefix' => Config::get('settings.admin_prefix')), function()
{
	// squadron cockpit
	Route::get('', 'SquadronController@index');
	
	// articles sections/actions
	Route::group(array('prefix' => 'article'), function()
	{
		Route::get('', 				'ArticleController@index');
		Route::get('edit/{id?}', 	'ArticleController@edit');
		Route::post('create', 		'ArticleController@create');
	});
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);