<?php

class AdminController extends BaseController {

	public $restful = true;

	public function getIndex() {
		if(!Auth::check()) 
			return View::make('no_user_id');
			
		return View::make('admin');
	}

	public function getAllMokjangs() {
		if(!Auth::check()) 
			return View::make('no_user_id');

		$results = DB::select('select * from report_mokjang');

		return Response::json(array('mokjangs' => $results));
	}

	public function postDeleteMokjang() {
		if(!Auth::check()) 
			return View::make('no_user_id');

		$mokjangId = Input::get('mokjangId');

		$result = null;

		try {
			$result = DB::delete('delete from report_mokjang where id = (?)', array($mokjangId));
		} catch (Exception $e) {

		}

		return Response::json(array('status'=>$result));
	}

	public function postAddMokjang() {
		if(!Auth::check()) 
			return View::make('no_user_id');

		$mokjangName = Input::get('mokjangName');
		$mokjaName = Input::get('mokjaName');
		$mokjaId = Input::get('mokjaId');
		$groupName = Input::get('groupName');
		
		$result = null;

		try {
			$result = DB::insert('insert into report_mokjang 
				(
					mokjang_name, 
					mokja_name, 
					mokja_id, 
					group_name
				) values (?, ?, ?, ?)', array(
					$mokjangName, 
					$mokjaName, 
					$mokjaId, 
					$groupName
				)
			);
		} catch(Exception $e) {
			$errorCode = $e->getCode();
			Log::debug("Wait! Are you here?: $errorCode");
			Log::debug("This is the error: $e");
			$result = $e->getCode();
		}

		$idObject = null;

		try {
			$idObject = DB::select('select MAX(id) from report_mokjang');
		} catch(Exception $e) {
			
		}

		$id = current($idObject)->{'MAX(id)'};
		Log::debug("Added mokjang. Id: $id");

		return Response::json(array('status' => $result, 'id' => $id));
	}

	public function postUpdateMokjang() {
		if(!Auth::check()) 
			return View::make('no_user_id');

		$mokjangName = Input::get('mokjangName');
		$mokjaName = Input::get('mokjaName');
		$mokjaId = Input::get('mokjaId');
		$groupName = Input::get('groupName');
		$mokjangId = Input::get('mokjangId');

		$result = null;
		Log::info("$mokjangName, $mokjaName, $mokjaId, $groupName, $mokjangId");
		try {
			$result = DB::update('update report_mokjang set 
				mokjang_name = "' . $mokjangName . '", ' .
				'mokja_name = "' . $mokjaName . '", ' .
				'mokja_id = "' . $mokjaId . '", ' .
				'group_name = "' . $groupName . '" where 
				id = (?)', array(
					$mokjangId
				)
			);
		} catch(Exception $e) {
			$errorCode = $e->getCode();
			Log::debug("Wait! Are you here?: $errorCode");
			Log::debug("This is the error: $e");
			$result = $e->getCode();
		}

		Log::info("Result: $result");
		return Response::json(
			array(
				'status' => $result,
				'mokjangName' => $mokjangName,
				'mokjaName' => $mokjaName,
				'mokjaId' => $mokjaId,
				'groupName' => $groupName));
	}

	public function postFindMokjang() {
		if(!Auth::check()) 
			return View::make('no_user_id');

		$mokjangId = Input::get('mokjangId');
		Log::debug("Received mokjangId: $mokjangId");
		$result = null;

		try {
			$result = DB::select('select * from report_mokjang where id = (?)', array($mokjangId));
		} catch(Exception $e) {
			$errorCode = $e->getCode();
			Log::debug("This is the error: $e");

			$result = $e->getCode();
		}

		$mokjangName = $result[0]->mokjang_name;
		$mokjaName = $result[0]->mokja_name;
		$mokjaId = $result[0]->mokja_id;
		$groupName = $result[0]->group_name;

		return Response::json(array(
			'mokjangName' => $mokjangName,
			'mokjaName' => $mokjaName,
			'mokjaId' => $mokjaId,
			'groupName' => $groupName));
	}

	public function postAddTerm() {
		if(!Auth::check()) 
			return View::make('no_user_id');

		$termName = $_POST["termName"];
		$startingSunday = $_POST["startingSunday"];
		$endingSunday = $_POST["endingSunday"];

		Log::info("$termName, $startingSunday, $endingSunday");

		$result = null;
		// Replace into the report db this current report. 
		try {
			$result = DB::insert('replace into report_term
				(
					term_name,
					starting_sunday,
					ending_sunday
				) values (?,?,?)', array(
					$termName,
					$startingSunday,
					$endingSunday
				)
			);
		} catch (Exception $e) {
			Log::error("Error while running DB query in UserController for postProcessForm:\n $e");
		}

		return Response::json(array('status' => $result));

	}

	public function getAllTerms() {
		if(!Auth::check()) 
			return View::make('no_user_id');

		$results = DB::select('select * from report_term order by starting_sunday asc');

		return Response::json(array('terms' => $results));
	}

	public function postDeleteTerm() {
		if(!Auth::check()) 
			return View::make('no_user_id');

		$termId = $_POST['termId'];

		Log::info("Deleting $termId");

		$result = null;

		try {
			$result = DB::delete('delete from report_term where id = (?)', array($termId));
		} catch (Exception $e) {

		}

		return Response::json(array('status'=>$result));
	}

	public function postUpdateTerm() {
		if(!Auth::check()) 
			return View::make('no_user_id');

		$termId = $_POST['termId'];
		$termName = $_POST['termName'];
		$startingSunday = $_POST['startingSunday'];
		$endingSunday = $_POST['endingSunday'];

		$result = null;
		
		try {
			$result = DB::update('update report_term set 
				term_name = "' . $termName . '", ' .
				'starting_sunday = "' . $startingSunday . '", ' .
				'ending_sunday = "' . $endingSunday . '" where 
				id = (?)', array(
					$termId
				)
			);
		} catch(Exception $e) {
			$errorCode = $e->getCode();
			Log::debug("Wait! Are you here?: $errorCode");
			Log::debug("This is the error: $e");
			$result = $e->getCode();
		}

		return Response::json(
			array('status' => $result));
	}

}