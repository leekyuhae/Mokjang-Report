<?php

use Illuminate\Database\Migrations\Migration;

class CreateMokoneReportTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('mokone_weekly', function($table)
		{
			$table->increments('id');
			$table->integer('mokone_id');
			$table->date('week');
			$table->boolean('attendance');
			$table->boolean('pastor_visit');
			$table->string('news');
			$table->string('prayer_request');
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
		Schema::drop('mokone_weekly');
	}

}