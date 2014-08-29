<?php

use FI\Modules\Activities\Models\Activity;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Version223 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Delete invalid quote activity records if they exist
		Activity::where('audit_type', 'FI\Modules\Quotes\Models\Quote')
		->whereNotIn('audit_id', function($query)
		{
			$query->select('id')->from('quotes');
		})->delete();

		// Delete invalid invoice activity records if they exist
		Activity::where('audit_type', 'FI\Modules\Invoices\Models\Invoice')
		->whereNotIn('audit_id', function($query)
		{
			$query->select('id')->from('invoices');
		})->delete();

		$setting = App::make('SettingRepository');

		$setting->save('version', '2.2.3');
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
