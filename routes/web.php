<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// patterns
Route::pattern('year', '[0-9]{4}');
Route::pattern('month', '[0-9]{2}');

// homepage
Route::get('', 'WelcomeController@index');

// articles section (if a prefix is set)
Route::group(['prefix' => env('articles_index', 'blog')], function() {
    // article index
    Route::get('', 'ArticleController@FE_index');

    // switch based on article_url_structure
    switch(env('article_url_structure', '{year}/{month}/{uri}')) {
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
Route::group(['prefix' => env('admin_prefix', 'admin')], function() {
    // authed users only
    Route::group(['middleware' => ['auth']], function() {
        // squadron base
        Route::get('', 'SquadronController@index');

        // assets sections/actions
        Route::group(['prefix' => 'assets'], function() {
            Route::get('', 					'AssetsFolderController@index');
            Route::get('folder/{id}', 		'AssetsFolderController@show');
            Route::post('folder/create', 	'AssetsFolderController@create');
            Route::post('asset/create', 	'AssetController@create');
        });

        // articles sections/actions
        Route::group(['prefix' => 'articles'], function() {
            Route::get('', 					'ArticleController@index');
            Route::get('edit/{id?}', 		'ArticleController@edit');
            Route::post('create', 			'ArticleController@create');
        });
    });
});

Route::get('/home', 'HomeController@index');

Auth::routes();