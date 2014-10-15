<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Activities extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activities', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('object');
			$table->string('activity');
			$table->integer('parent_id');
			$table->text('info')->nullable();

			$table->index('object');
			$table->index('activity');
			$table->index('parent_id');
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
	}

}
