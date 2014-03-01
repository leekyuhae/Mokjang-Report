<?php

use Illuminate\Database\Migrations\Migration;

class CreateReportMokjangTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('report_mokjang', function($table)
		{
			$table->increments('id');
			$table->string('mokjang_name');
			$table->string('mokja_name');
			$table->string('mokja_id');
			$table->string('group_name');

			$table->unique('mokjang_name'); 
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('report_mokjang');
	}

}