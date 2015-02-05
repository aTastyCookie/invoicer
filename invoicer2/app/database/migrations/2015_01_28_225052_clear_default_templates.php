<?php

use FI\Modules\Clients\Models\Client;
use FI\Modules\Invoices\Models\Invoice;
use FI\Modules\Quotes\Models\Quote;
use FI\Modules\Settings\Models\Setting;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClearDefaultTemplates extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $invoiceTemplate = Setting::where('setting_key', 'invoiceTemplate')->first()->setting_value;
        $quoteTemplate   = Setting::where('setting_key', 'quoteTemplate')->first()->setting_value;

        Client::where('invoice_template', $invoiceTemplate)->update(array('invoice_template' => null));
        Client::where('quote_template', $quoteTemplate)->update(array('quote_template' => null));
        Invoice::where('template', $invoiceTemplate)->update(array('template' => null));
		Quote::where('template', $quoteTemplate)->update(array('template' => null));
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
