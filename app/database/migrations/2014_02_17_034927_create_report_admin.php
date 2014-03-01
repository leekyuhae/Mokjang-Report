<?php

use Illuminate\Database\Migrations\Migration;

class CreateAdminIdTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('report_admin', function($table)
		{
			$table->increments('id');
			$table->string('admin_id');
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
		Schema::drop('report_admin');
	}

}