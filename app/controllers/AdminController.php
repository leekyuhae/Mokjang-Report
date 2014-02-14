<?php

class AdminController extends BaseController {

	public $restful = true;

	public function getIndex() {
		return View::make('admin');
	}

	public function getMokjangs() {
		$results = DB::select('select * from report_mokjangs');

		return Response::json(array('mokjangs' => $results));
	}

	public function postAddMokjang() {
		$mokjangName = Input::get('mokjangName');
		$mokjaName = Input::get('mokjaName');
		$mokjaId = Input::get('mokjaId');
		$groupName = Input::get('groupName');

		Log::debug("Does this not show: $mokjangName");
		
		$result = null;

		try {
			$result = DB::insert('insert into report_mokjangs (mokjang_name, mokja_name, mokja_id, group_name) values (?, ?, ?, ?)', array($mokjangName, $mokjaName, $mokjaId, $groupName));
		} catch(Exception $e) {
			$errorCode = $e->getCode();
			Log::debug("Wait! Are you here?: $errorCode");
			Log::debug("This is the error: $e");
			$result = $e->getCode();
		}

		return Response::json(array('status' => $result));
	}

	public function getFindMokjang() {
		$mokjangName = Input::get('mokjangName');

		Log::debug("getFindMokjang::Received Input: $mokjangName");
		
		$result = null;

		try {
			$result = DB::select('select * from report_mokjangs where mokjang_name = ?', array($mokjangName));
		} catch(Exception $e) {
			$errorCode = $e->getCode();
			Log::debug("Wait! Are you here?: $errorCode");
			Log::debug("This is the error: $e");
			$result = $e->getCode();
		}

		$mokjaName = $result[0]->mokja_name;
		$mokjaId = $result[0]->mokja_id;
		$groupName = $result[0]->group_name;
		Log::debug("Exploring Data: $mokjaName");

		return Response::json(array(
			'mokjaName' => $mokjaName,
			'mokjaId' => $mokjaId,
			'groupName' => $groupName));
	}

}