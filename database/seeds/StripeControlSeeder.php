<?php

use Illuminate\Database\Seeder;
use App\MasterSetting;

class StripeControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $settings = new MasterSetting();
        $site = $settings->siteData();

        $site['stripe_key']  = 'pk_test_TYooMQauvdEDq54NiTphI7jx';
        $site['stripe_secret']  = 'sk_test_4eC39HqLyjWDarjtT1zdp7dc';

        foreach ($site as $key => $value) {
            MasterSetting::updateOrCreate(['master_title' => $key],['master_value' => $value]);
        }

    }
}
