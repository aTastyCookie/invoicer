<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Commands;

use App;
use Config;
use Crypt;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Recurring extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fi:recurring';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Checks to see if there are any recurring invoices to create.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Checking for recurring invoices to create');

		App::make('SettingRepository')->setAll();

        Config::set('mail.driver', (Config::get('fi.mailDriver')) ? Config::get('fi.mailDriver') : 'smtp');
        Config::set('mail.host', Config::get('fi.mailHost'));
        Config::set('mail.port', Config::get('fi.mailPort'));
        Config::set('mail.encryption', Config::get('fi.mailEncryption'));
        Config::set('mail.username', Config::get('fi.mailUsername'));
        Config::set('mail.password', (Config::get('fi.mailPassword')) ? Crypt::decrypt(Config::get('fi.mailPassword')) : '');
        Config::set('mail.sendmail', Config::get('fi.mailSendmail'));

		$count = App::make('RecurringInvoiceRepository')->recurInvoices();

		$this->info('Recurring invoices generated: ' . $count);
	}

}