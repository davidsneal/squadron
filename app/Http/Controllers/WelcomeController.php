<?php

namespace App\Http\Controllers;
	
use Config;

class WelcomeController extends Controller {

	/**
	 * Show the application welcome screen to the user.
	 */
	public function index()
	{
		// prepare data
		$data = [
			'heading' => env('site_name'),
		];

		return view('themes/'.env('active_theme', 'squadron').'/welcome', $data);
	}

}
