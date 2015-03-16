<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Config;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
		
		$this->redirectPath = '/'.Config::get('settings.admin_prefix');

		$this->middleware('guest', ['except' => 'getLogout']);
	}
	
	/**
	 * Show the application registration form (if enabled).
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		// if public registration is enabled
		if(Config::get('settings.allow_public_registration') === true)
		{
			return view('auth.register');
		}
		// public registration disabled
		else
		{
			abort(404);
		}
	}
	
	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			// if the user has admin rights
			if(\Entrust::hasRole('admin') OR \Entrust::hasRole('super_admin'))
			{
				// redirect to admin
				return redirect()->intended('/'.Config::get('settings.admin_prefix'));
			}
			// not admin
			else
			{
				// direct to admin
				return redirect()->intended(Config::get('settings.non_admin_login_redirect'));
			}
		}

		return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => $this->getFailedLoginMessage(),
					]);
	}
	
		/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->auth->login($this->registrar->create($request->all()));

		// redirect newly registered and logged in users
		return redirect(Config::get('settings.new_register_redirect'));
	}

}
