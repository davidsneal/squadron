<?php namespace App\Helpers;

class Squadron {

	/**
	 * Show a permissions error message
	 *
	 * @return Response
	 */
	public static function permissionsError($permission)
	{
		// prepare data
		$data = [
			'alert_class' 	=> 'danger',
			'alert_message' => "You do not have the required '$permission' permission to access this page"
		];

		// return error view
		return response()->view('squadron.errors.general', $data);
	}

}
