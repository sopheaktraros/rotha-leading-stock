<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $settings = [
		    'app_name' => "Camsolution",
		    'logo' => url('logo-white.png'),
		    'address' => 'Beoung Kork 2, Toul Kork, Phnom Penh',
		    'email' => '',
		    'phone' => '(855) 011 326 231 / 015 227 782',
			'website' => 'www.camsolution.biz',
			'exchange_rate' => 4000
	    ];

	    foreach ($settings as $name => $value) {
		    DB::table('settings')->insert([
			    'setting_name' => $name,
			    'setting_value' => $value
		    ]);
	    }
    }
}
