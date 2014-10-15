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
            $table->string('invoice_template');
            $table->string('quote_template');
        });

		Schema::table('invoices', function($table)
        {
            $table->string('template');
        });

        Schema::table('quotes', function($table)
        {
            $table->string('template');
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
