<?php

class UserController extends BaseController {
	public $restful = true;

	public function getIndex() {
		$mokjaId = Input::get('mokjaId');
		$mokjangInfo = null;

		// Check if mokjaId is given with get reqeust. If not, return no_user_id error page.
		if (!$mokjaId) {
			return View::make('no_user_id');
		}

		// Get mokjang_name and group_name for the report.
		try {
			$mokjangInfo = DB::select('select * from mokjangs where mokja_id=(?)', array($mokjaId));
		} catch (Exception $e) {
			Log::error("Error while running DB query in UserController for mokjangInfo: $e");
		}

		// When there is no mokja_id found in the db
		if (!$mokjangInfo) {
			return View::make('no_user_id');	
		}

		$mokjangName = $mokjangInfo[0]->mokjang_name;
		$groupName = $mokjangInfo[0]->group_name;
		$mokjangId = $mokjangInfo[0]->id;

		return View::make('user')
					->with('mokjangId', $mokjangId)
					->with('mokjangName', $mokjangName)
					->with('groupName', $groupName);
	}

	public function getMokones() {
		$mokjangName = Input::get('mokjangName');

		// Get all mokone registered for this mokjang.
		$mokoneList = null;
		try {
			$mokoneList = DB::select('select * from mokone where mokjang_name=(?)', array($mokjangName));
		} catch (Exception $e) {
			Log::error("Error while running DB query in UserController for getMokones: $e");
		}

		return Response::json(array('mokoneList' => $mokoneList));
	}

	public function postProcessForm() {
		$mokjangId = $_POST["mokjangId"];
		$mokjangName = $_POST["mokjangName"];
		$meetingDate = $_POST["meetingDate"];
		$meetingPlace = $_POST["meetingPlace"];
		$mondayOfTheWeek = $_POST["week"];

		Log::info("Received! the form: $mokjangName, $meetingDate, $mondayOfTheWeek");
		$result = null;

		// Insert or replace into the report db this current report. 
		try {
			$result = DB::insert('replace into report
				(
					mokjang_id,
					week,
					meeting_date,
					meeting_place
				) values (?,STR_TO_DATE(?,\'%m/%d/%Y\'),STR_TO_DATE(?,\'%m/%d/%Y\'),?)', array(
					$mokjangId,
					$mondayOfTheWeek,
					$meetingDate,
					$meetingPlace
				)
			);
		} catch (Exception $e) {
			Log::error("Error while running DB query in UserController for postProcessForm:\n $e");
		}

		$mokoneIds = null;
		// Get all Ids of mokones belong to this mokjang
		try {
			$mokoneIds = DB::select('select id from mokone where mokjang_name=(?)', array($mokjangName));
		} catch (Exception $e) {
			Log::error("Error while running DB query in UserController for postProcessForm:\n $e");
		}

		foreach ($_POST as $key => $value) {
			echo "$key: $value <br>";
		}

		foreach ($mokoneIds as $key => $value) {
			$id = $value->id;
			$doReport = False;
			$attended = False;
			if( isset($_POST["attendance" . $id]) && $_POST["attendance" . $id]!="" ) {
				$attended = True;
				$doReport = True;
			}

			$pastorVisit = False;
			if( isset($_POST["pastor-visit" . $id]) && $_POST["pastor-visit" . $id]!="" ) {
				$pastorVisit = True;
				$doReport = True;
			}

			$news = "";
			if( isset($_POST["news" . $id]) && $_POST["news" . $id]!="" ) {
				$news = $_POST["news" . $id];
				$doReport = True;
			}
			
			$prayerRequest = "";
			if( isset($_POST["prayer-request" . $id]) && $_POST["prayer-request" . $id]!="" ) {
				$prayerRequest = $_POST["prayer-request" . $id];
				$doReport = True;
			}

			if ($doReport) {
				try{
					DB::insert('replace into mokone_weekly
						(
							mokone_id,
							week,
							attendance,
							pastor_visit,
							news,
							prayer_request
						) values (?, STR_TO_DATE(?, \'%m/%d/%Y\'),?,?,?,?)', array(
							$id,
							$mondayOfTheWeek,
							$attended,
							$pastorVisit,
							$news,
							$prayerRequest
						)
					);
				} catch (Exception $e) {
					Log::error("Error while running DB query in UserController for postProcessForm:\n $e");
				}
			}
		}

	}

	public function postDeleteMokone() {
		$id = Input::get('id');

		$deleteResult = 0;
		try {
			$deleteResult = DB::delete('delete from mokone where id=(?)', array($id));
		} catch (Exception $e) {
			Log::error("Error while running DB query in UserController for postDeleteMokone: $e");
		}

		return Response::json(array('result' => $deleteResult));
	}

	public function postAddMokone() {
		$status = Input::get('status');
		$groupName = Input::get('groupName');
		$mokjangName = Input::get('mokjangName');
		$husbandName = "";
		$wifeName = "";
		$result = "";

		if($status == "single") {
			$mokoneName = Input::get('mokoneName');
			$sex = Input::get('sex');

			if($sex == "male") {
				$husbandName = $mokoneName;
			} else {
				$wifeName = $mokoneName;
			}

		} else { // status == "married"
			$husbandName = Input::get('husbandName');
			$wifeName = Input::get('wifeName');
		}

		try {
			$result = DB::insert('insert into mokone 
				(
					marital_status, 
					mokjang_name, 
					group_name, 
					husband_name, 
					wife_name
				) values (?,?,?,?,?)',array(
					$status,
					$mokjangName,
					$groupName,
					$husbandName,
					$wifeName
				)
			);
		} catch (Exception $e) {

		}
		$idObject = DB::select('select MAX(id) from mokone');
		$id = current($idObject)->{'MAX(id)'};

		return Response::json(array('status' => $result,
									'id' => $id));
	}

}