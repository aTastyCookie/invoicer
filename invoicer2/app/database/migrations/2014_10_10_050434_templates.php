<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Templates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('clients', function($table)
        {
            $table->string('invoice_template')->nullable();
            $table->string('quote_template')->nullable();
        });

		Schema::table('invoices', function($table)
        {
            $table->string('template')->nullable();
        });

        Schema::table('quotes', function($table)
        {
            $table->string('template')->nullable();
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
