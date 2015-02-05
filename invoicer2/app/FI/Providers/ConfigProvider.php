<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Providers;

use App;
use Config;
use Crypt;
use Session;

use FI\Libraries\DateFormatter;

use Illuminate\Support\ServiceProvider;

class ConfigProvider extends ServiceProvider {

    /**
     * Register the service provider
     * @return void
     */
    public function register() {}

    /**
     * Bootstrap the application events
     * @return void
     */
    public function boot()
    {
        App::before(function($request)
        {
            // Set the application specific settings under fi. prefix (fi.settingName)
            $settings = App::make('SettingRepository');

            if ($settings->setAll())
            {
                // This one needs a little special attention
                $dateFormats = DateFormatter::formats();
                Config::set('fi.datepickerFormat', $dateFormats[Config::get('fi.dateFormat')]['datepicker']);

                // Set the environment timezone to the application specific timezone, if available, otherwise UTC
                date_default_timezone_set((Config::get('fi.timezone') ?: Config::get('app.timezone')));

                $mailPassword = '';

                try
                {
                    $mailPassword = (Config::get('fi.mailPassword')) ? Crypt::decrypt(Config::get('fi.mailPassword')) : '';
                }
                catch (\Exception $e)
                {
                    Session::flash('error', '<strong>' . trans('fi.error')  . '</strong> - ' . trans('fi.mail_hash_error'));
                }

                // // Override the framework mail configuration with the values provided by the application
                Config::set('mail.driver', (Config::get('fi.mailDriver')) ? Config::get('fi.mailDriver') : 'smtp');
                Config::set('mail.host', Config::get('fi.mailHost'));
                Config::set('mail.port', Config::get('fi.mailPort'));
                Config::set('mail.encryption', Config::get('fi.mailEncryption'));
                Config::set('mail.username', Config::get('fi.mailUsername'));
                Config::set('mail.password', $mailPassword);
                Config::set('mail.sendmail', Config::get('fi.mailSendmail'));
            }

            App::setLocale((Config::get('fi.language')) ?: 'en');

            Config::set('mailConfigured', (Config::get('fi.mailDriver') ? true : false));
        });
    }  

}