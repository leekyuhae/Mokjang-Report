<?php

use Illuminate\Database\Migrations\Migration;

class CreateReportMokoneWeekly extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('report_mokone_weekly', function($table)
		{
			$table->increments('id');
			$table->integer('mokone_id');
			$table->date('week');
			$table->boolean('attendance');
			$table->boolean('pastor_visit');
			$table->string('news', 1024);
			$table->string('prayer_request', 1024);
			$table->unique(array('mokone_id','week'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('report_mokone_weekly');
	}

}