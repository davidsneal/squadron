<?php namespace App\Http\Middleware;

use Closure;
use View;

class AdminMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// if user has access
		if(\Entrust::hasRole('admin') OR \Entrust::hasRole('super_admin'))
		{
			// continue
			return $next($request);
		}
		else
		{
			// prepare data
			$data = [
				'alert_class' 	=> 'danger',
				'alert_message' => 'You do not have sufficient rights to access this page'
			];

			// return error view
			return response()->view('squadron.errors.general', $data);
		}
	}

}
