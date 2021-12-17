<?php

use Illuminate\Database\Seeder;
use App\MasterSetting;

class MailControlSeeder extends Seeder
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
