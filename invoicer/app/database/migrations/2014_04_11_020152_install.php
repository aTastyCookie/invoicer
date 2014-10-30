<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;

class Install extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->text('address')->nullable();
			$table->string('phone')->nullable();
			$table->string('fax')->nullable();
			$table->string('mobile')->nullable();
			$table->string('email')->nullable();
			$table->string('web')->nullable();
			$table->string('url_key');
			$table->boolean('active')->default(1);

			$table->index('name');
			$table->index('active');
		});

		Schema::create('clients_custom', function($table)
		{
			$table->integer('client_id');
			$table->timestamps();

			$table->primary('client_id');
		});

		Schema::create('custom_fields', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('table_name');
			$table->string('column_name');
			$table->string('field_label');
			$table->string('field_type');
			$table->text('field_meta');

			$table->index('table_name');
		});

		Schema::create('invoices', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id');
			$table->integer('client_id');
			$table->integer('invoice_group_id');
			$table->integer('invoice_status_id');
			$table->date('due_at');
			$table->string('number');
			$table->text('terms')->nullable();
			$table->text('footer')->nullable();
			$table->string('url_key');

			$table->index('user_id');
			$table->index('client_id');
			$table->index('invoice_group_id');
			$table->index('invoice_status_id');
		});

		Schema::create('invoices_custom', function($table)
		{
			$table->integer('invoice_id');
			$table->timestamps();

			$table->primary('invoice_id');
		});

		Schema::create('invoice_amounts', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id');
			$table->decimal('item_subtotal', 10, 2)->default(0.00);
			$table->decimal('item_tax_total', 10, 2)->default(0.00);;
			$table->decimal('tax_total', 10, 2)->default(0.00);;
			$table->decimal('total', 10, 2)->default(0.00);;
			$table->decimal('paid', 10, 2)->default(0.00);;
			$table->decimal('balance', 10, 2)->default(0.00);;

			$table->index('invoice_id');
		});

		Schema::create('invoice_groups', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('prefix');
			$table->integer('next_id')->default(1);
			$table->integer('left_pad')->default(0);
			$table->boolean('prefix_year')->default(0);
			$table->boolean('prefix_month')->default(0);
		});

		Schema::create('invoice_items', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id');
			$table->integer('tax_rate_id');
			$table->string('name');
			$table->text('description');
			$table->decimal('quantity', 10, 2)->default(0.00);;
			$table->decimal('price', 10, 2)->default(0.00);;
			$table->integer('display_order')->default(0);

			$table->index('invoice_id');
			$table->index('tax_rate_id');
			$table->index('display_order');
		});

		Schema::create('invoice_item_amounts', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('item_id');
			$table->decimal('subtotal', 10, 2)->default(0.00);
			$table->decimal('tax_total', 10, 2)->default(0.00);
			$table->decimal('total', 10, 2)->default(0.00);

			$table->index('item_id');
		});

		Schema::create('invoice_tax_rates', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id');
			$table->integer('tax_rate_id');
			$table->boolean('include_item_tax')->default(0);
			$table->decimal('tax_total', 10, 2)->default(0.00);

			$table->index('invoice_id');
			$table->index('tax_rate_id');
		});

		Schema::create('item_lookups', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->text('description');
			$table->decimal('price', 10, 2)->default(0.00);
		});

		Schema::create('payments', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id');
			$table->integer('payment_method_id');
			$table->date('paid_at');
			$table->decimal('amount', 10, 2)->default(0.00);
			$table->text('note');

			$table->index('invoice_id');
			$table->index('payment_method_id');
			$table->index('amount');
		});

		Schema::create('payments_custom', function($table)
		{
			$table->integer('payment_id');
			$table->timestamps();

			$table->primary('payment_id');
		});

		Schema::create('payment_methods', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
		});

		Schema::create('quotes', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id')->default('0');
			$table->integer('user_id');
			$table->integer('client_id');
			$table->integer('invoice_group_id');
			$table->integer('quote_status_id');
			$table->date('expires_at');
			$table->string('number');
			$table->text('footer')->nullable();
			$table->string('url_key');

			$table->index('user_id');
			$table->index('client_id');
			$table->index('invoice_group_id');
			$table->index('number');
		});

		Schema::create('quotes_custom', function($table)
		{
			$table->integer('quote_id');
			$table->timestamps();

			$table->primary('quote_id');
		});

		Schema::create('quote_amounts', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('quote_id');
			$table->decimal('item_subtotal', 10, 2)->default(0.00);
			$table->decimal('item_tax_total', 10, 2)->default(0.00);
			$table->decimal('tax_total', 10, 2)->default(0.00);
			$table->decimal('total', 10, 2)->default(0.00);

			$table->index('quote_id');
		});

		Schema::create('quote_items', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('quote_id');
			$table->integer('tax_rate_id');
			$table->string('name');
			$table->text('description');
			$table->decimal('quantity', 10, 2)->default(0.00);
			$table->decimal('price', 10, 2)->default(0.00);
			$table->integer('display_order');

			$table->index('quote_id');
			$table->index('display_order');
			$table->index('tax_rate_id');
		});

		Schema::create('quote_item_amounts', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('item_id');
			$table->decimal('subtotal', 10, 2)->default(0.00);
			$table->decimal('tax_total', 10, 2)->default(0.00);
			$table->decimal('total', 10, 2)->default(0.00);

			$table->index('item_id');
		});

		Schema::create('quote_tax_rates', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('quote_id');
			$table->integer('tax_rate_id');
			$table->boolean('include_item_tax')->default(0);
			$table->decimal('tax_total', 10, 2)->default(0.00);

			$table->index('quote_id');
			$table->index('tax_rate_id');
		});

		Schema::create('recurring_invoices', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id');
			$table->integer('recurring_frequency');
			$table->integer('recurring_period');
			$table->dateTime('generate_at');
		});

		Schema::create('settings', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('setting_key');
			$table->text('setting_value');

			$table->index('setting_key');
		});

		Schema::create('tax_rates', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->decimal('percent', 5, 2)->default(0.00);
		});

		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('email');
			$table->string('password');
			$table->string('name');
			$table->string('company')->nullable();
			$table->text('address')->nullable();
			$table->string('phone')->nullable();
			$table->string('fax')->nullable();
			$table->string('mobile')->nullable();
			$table->string('web')->nullable();
		});

		$invoiceGroup = App::make('InvoiceGroupRepository');

		$invoiceGroup->create(
			array(
				'name'         => trans('fi.invoice_default'), 
				'next_id'      => 1, 
				'left_pad'     => 0, 
				'prefix'       => 'INV', 
				'prefix_year'  => 0, 
				'prefix_month' => 0
			)
		);

		$invoiceGroup->create(
			array(
				'name'         => trans('fi.quote_default'), 
				'next_id'      => 1, 
				'left_pad'     => 0, 
				'prefix'       => 'QUO', 
				'prefix_year'  => 0, 
				'prefix_month' => 0
			)
		);

		$settingRepo = App::make('SettingRepository');
		
		$settings = array(
			array(
				'setting_key'   => 'language',
				'setting_value' => 'en'
			),
			array(
				'setting_key'   => 'dateFormat',
				'setting_value' => 'm/d/Y'
			),
			array(
				'setting_key'   => 'currencySymbol',
				'setting_value' => '$'
			),
			array(
				'setting_key'   => 'currencySymbolPlacement',
				'setting_value' => 'before'
			),
			array(
				'setting_key'   => 'thousandsSeparator',
				'setting_value' => ','
			),
			array(
				'setting_key'   => 'decimalPoint',
				'setting_value' => '.'
			),
			array(
				'setting_key'   => 'taxRateDecimalPlaces',
				'setting_value' => '2'
			),
			array(
				'setting_key'   => 'invoiceTemplate',
				'setting_value' => 'default.blade.php'
			),
			array(
				'setting_key'   => 'invoicesDueAfter',
				'setting_value' => '30'
			),
			array(
				'setting_key'   => 'invoiceGroup',
				'setting_value' => '1'
			),
			array(
				'setting_key'   => 'quoteTemplate',
				'setting_value' => 'default.blade.php'
			),
			array(
				'setting_key'   => 'quotesExpireAfter',
				'setting_value' => '15'
			),
			array(
				'setting_key'   => 'quoteGroup',
				'setting_value' => '2'
			),
			array(
				'setting_key'   => 'invoiceTerms',
				'setting_value' => ''
			),
			array(
				'setting_key'   => 'automaticEmailOnRecur',
				'setting_value' => '0'
			),
			array(
				'setting_key'   => 'markInvoicesSentPdf',
				'setting_value' => '0'
			),
			array(
				'setting_key'   => 'markQuotesSentPdf',
				'setting_value' => '0'
			),
			array(
				'setting_key'   => 'invoiceTaxRate',
				'setting_value' => '0'
			),
			array(
				'setting_key'   => 'includeItemTax',
				'setting_value' => '0'
			),
			array(
				'setting_key'   => 'itemTaxRate',
				'setting_value' => '0'
			),
			array(
				'setting_key'   => 'mailDriver',
				'setting_value' => 'mail'
			),
			array(
				'setting_key'   => 'mailHost',
				'setting_value' => ''
			),
			array(
				'setting_key'   => 'mailPort',
				'setting_value' => ''
			),
			array(
				'setting_key'   => 'mailUsername',
				'setting_value' => ''
			),
			array(
				'setting_key'   => 'mailPassword',
				'setting_value' => ''
			),
			array(
				'setting_key'   => 'mailEncryption',
				'setting_value' => '0'
			),
			array(
				'setting_key'   => 'mailSendmail',
				'setting_value' => ''
			),
			array(
				'setting_key'   => 'timezone',
				'setting_value' => 'Europe/Moscow'
			),
			array(
				'setting_key'   => 'attachPdf',
				'setting_value' => 0
			),
			array(
				'setting_key'   => 'automaticEmailOnRecur',
				'setting_value' => 1
			)
		);

		foreach ($settings as $setting)
		{
			$settingRepo->save($setting['setting_key'], $setting['setting_value']);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
		Schema::drop('clients_custom');
		Schema::drop('custom_fields');
		Schema::drop('invoices');
		Schema::drop('invoices_custom');
		Schema::drop('invoice_amounts');
		Schema::drop('invoice_groups');
		Schema::drop('invoice_items');
		Schema::drop('invoice_item_amounts');
		Schema::drop('invoice_tax_rates');
		Schema::drop('item_lookups');
		Schema::drop('payments');
		Schema::drop('payments_custom');
		Schema::drop('payment_methods');
		Schema::drop('quotes');
		Schema::drop('quotes_custom');
		Schema::drop('quote_amounts');
		Schema::drop('quote_items');
		Schema::drop('quote_item_amounts');
		Schema::drop('quote_tax_rates');
		Schema::drop('recurring_invoices');
		Schema::drop('settings');
		Schema::drop('tax_rates');
		Schema::drop('users');
	}

}