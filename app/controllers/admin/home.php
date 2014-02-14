<?php

class AdminHomeController extends AdminController {
	public $restful = true;

	public function init() {
		$results = DB::select('select * from active_interval where id = ?', array(1));
		if(!$results) {
			return View::make('user')->with('message', 'from Admin Controller');
		}
	}
	
	public function getCurrentDate() {
		date_default_timezone_get('America/Chicago');
		$date = date('Y/m/d');

		return $date;
	}
}