<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use FI\Modules\Activities\Models\Activity;

class ActivitiesUpdate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activities', function($table)
		{
		    $table->renameColumn('object', 'audit_type');
		});

		Schema::table('activities', function($table)
		{
		    $table->renameColumn('parent_id', 'audit_id');
		});

		Activity::where('audit_type', 'quote')->update(array('audit_type' => 'FI\Modules\Quotes\Models\Quote'));
		Activity::where('audit_type', 'invoice')->update(array('audit_type' => 'FI\Modules\Invoices\Models\Invoice'));
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
