<?php

use FI\Modules\Currencies\Models\Currency;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Currencies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('code');
			$table->string('name');
			$table->string('symbol');
			$table->string('placement');
			$table->string('decimal');
			$table->string('thousands');
			
			$table->index('name');
		});

		Schema::table('clients', function($table)
		{
			$table->string('currency_code')->nullable();
		});

		Schema::table('invoices', function($table)
		{
			$table->string('currency_code')->nullable();
			$table->decimal('exchange_rate', 10, 7)->default('1');
		});

		Schema::table('quotes', function($table)
		{
			$table->string('currency_code')->nullable();
			$table->decimal('exchange_rate', 10, 7)->default('1');
		});

		Currency::create(array('name' => 'Russian Ruble', 'code' => 'RUB', 'symbol' => 'RUB', 'placement' => 'before', 'decimal' => '.', 'thousands' => ','));
		Currency::create(array('name' => 'Australian Dollar', 'code' => 'AUD', 'symbol' => '$', 'placement' => 'before', 'decimal' => '.', 'thousands' => ','));
		Currency::create(array('name' => 'Canadian Dollar', 'code' => 'CAD', 'symbol' => '$', 'placement' => 'before', 'decimal' => '.', 'thousands' => ','));
		Currency::create(array('name' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'placement' => 'before', 'decimal' => '.', 'thousands' => ','));
		Currency::create(array('name' => 'Pound Sterling', 'code' => 'GBP', 'symbol' => '£', 'placement' => 'before', 'decimal' => '.', 'thousands' => ','));
		Currency::create(array('name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$', 'placement' => 'before', 'decimal' => '.', 'thousands' => ','));

		App::make('SettingRepository')->save('baseCurrency', 'RUB');
		App::make('SettingRepository')->save('exchangeRateMode', 'automatic');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
