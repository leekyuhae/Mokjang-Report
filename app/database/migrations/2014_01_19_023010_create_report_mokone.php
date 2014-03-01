<?php

use Illuminate\Database\Migrations\Migration;

class CreateReportMokoneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('report_mokone', function($table)
		{
			$table->increments('id');
			$table->string('group_name');
			$table->string('mokjang_name');
			$table->string('marital_status');
			$table->string('husband_name');
			$table->string('wife_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('report_mokjone');
		//
	}

}