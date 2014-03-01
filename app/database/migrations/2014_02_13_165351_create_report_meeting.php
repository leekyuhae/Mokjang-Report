<?php

use Illuminate\Database\Migrations\Migration;

class CreateReportMeeting extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('report_meeting', function($table)
		{
			$table->increments('id');
			$table->integer('mokjang_id');
			$table->date('week');
			$table->date('meeting_date');
			$table->string('meeting_place');
			$table->unique(array('mokjang_id','week'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('report_meeting');
	}

}