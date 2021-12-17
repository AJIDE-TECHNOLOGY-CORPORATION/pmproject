<?php

use Illuminate\Database\Seeder;
use App\MasterSetting;

class MasterControlSeeder extends Seeder
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

        $site['site_title'] = 'Invoxi';
        $site['company_name'] = 'Invoxi';
        $site['company_address1'] = 'Sample Address <br>Kerala, India';
        $site['company_phone'] = '1234567890';
        $site['company_state'] = 'kerala';
        $site['company_city'] = 'kollam';
        $site['company_country'] = 'IN';
        $site['default_currency'] = '₹';
        $site['default_financialyear'] = date('Y');

        $site['company_zip'] = "691001";


        $site['stripe_key']  = 'pk_test_TYooMQauvdEDq54NiTphI7jx';
        $site['stripe_secret']  = 'sk_test_4eC39HqLyjWDarjtT1zdp7dc';
        $site['site_title'] = 'Invoxi';
  
         $site['mail_driver'] = 'smtp';
         $site['mail_port'] = '587';
         $site['mail_host'] = 'smtp.googlemail.com';
         $site['mail_encryption'] = 'tls';
         $site['mail_user_name'] = 'test@example.com';
         $site['mail_from_address'] = 'test@example.com';
         $site['mail_from_name'] = 'Test';
         
        foreach ($site as $key => $value) {
            MasterSetting::updateOrCreate(['master_title' => $key],['master_value' => $value]);
        }

    }
}
