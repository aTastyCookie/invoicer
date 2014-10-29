<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixTemplateFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('clients', function($table)
        {
            $table->renameColumn('invoice_template', 'old_invoice_template');
            $table->renameColumn('quote_template', 'old_quote_template');
        });

        Schema::table('clients', function($table)
        {
            $table->string('invoice_template')->nullable();
            $table->string('quote_template')->nullable();
        });

        Schema::table('invoices', function($table)
        {
            $table->renameColumn('template', 'old_template');
        });

        Schema::table('invoices', function($table)
        {
            $table->string('template')->nullable();
        });

        Schema::table('quotes', function($table)
        {
            $table->renameColumn('template', 'old_template');
        });

        Schema::table('quotes', function($table)
        {
            $table->string('template')->nullable();
        });

        DB::table('clients')->update(array('invoice_template' => DB::raw('old_invoice_template')));
        DB::table('clients')->update(array('quote_template' => DB::raw('old_quote_template')));
        DB::table('invoices')->update(array('template' => DB::raw('old_template')));
        DB::table('quotes')->update(array('template' => DB::raw('old_template')));

        Schema::table('clients', function($table)
        {
            $table->dropColumn('old_invoice_template');
            $table->dropColumn('old_quote_template');
        });

        Schema::table('invoices', function($table)
        {
            $table->dropColumn('old_template');
        });

        Schema::table('quotes', function($table)
        {
            $table->dropColumn('old_template');
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
