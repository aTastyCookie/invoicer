<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaxRateDecimals extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('tax_rates', function($table)
        {
            $table->renameColumn('percent', 'old_percent');
        });

        Schema::table('tax_rates', function($table)
        {
            $table->decimal('percent', 5, 3)->default(0.00);
        });

        DB::table('tax_rates')->update(array('percent' => DB::raw('old_percent')));

        Schema::table('tax_rates', function($table)
        {
            $table->dropColumn('old_percent');
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
