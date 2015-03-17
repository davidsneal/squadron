<?php namespace App\Http\Middleware;

use Closure;
use View;

// squadron helper
use App\Helpers\Squadron;

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
		if(\Entrust::can('access_squadron'))
		{
			// continue
			return $next($request);
		}
		else
		{
			// permissions error
			return Squadron::permissionsError('access_squadron');
		}
	}

}
