<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SquadronServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Squadron', function()
		{
		    return new \App\Helpers\SquadronHelper;
		});
	}

}
