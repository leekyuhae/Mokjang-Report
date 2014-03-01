<?php

use Illuminate\Database\Migrations\Migration;

class CreateReportTermTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('report_term', function($table)
		{
			$table->increments('id');
			$table->string('term_name');
			$table->date('starting_sunday');
			$table->date('ending_sunday');
			$table->unique('term_name');
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
		Schema::drop('report_term');
	}

}