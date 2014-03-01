<?php

class HomeController extends BaseController {

	public $restful = true;

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function getIndex() {
		return View::make('login');
	}

	public function postLogin() {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashedPassword = md5($password);

		Log::info("username: $username, password: $hashedPassword");

		$loginData = array(
			'user_id' => $username,
			'password' => $hashedPassword);

		if (Auth::attempt($loginData)) {

			$count = 0;
			try {
				$result = DB::select('select count(*) from report_mokjang where mokja_id=?', array($username));
				$count = $result[0]->{'count(*)'};

				if ($count > 0) {
					if(Auth::check()) {
						return Redirect::to('report/user');
					}
				} 

			} catch (Exception $e) {

			}
			
			$count = 0;
			try {
				$result = DB::select('select count(*) from report_admin where admin_id=?', array($username));
				$count = $result[0]->{'count(*)'};

				if ($count > 0) {
					return Redirect::to('report/admin');
				} 

			} catch (Exception $e) {

			}


		} else {
			Log::info("hmm, login not successful: $username");
		} 

		return View::make('no_user_id');
	}
}