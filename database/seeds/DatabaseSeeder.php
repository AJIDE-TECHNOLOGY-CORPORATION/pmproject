<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* admin credentials */
        User::create([
            'name'=>'Admin',
            'email'=>'demo@demo.com',
            'password'=>Hash::make('123456'),
            'user_type'=>'1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        /* seeder call */
        $this->call([
            CurrencyControlSeeder::class,
            TimezoneControlSeeder::class,
            MasterControlSeeder::class,
            CountryControlSeeder::class,
            FinancialYearControlSeeder::class,
            StripeControlSeeder::class,
            MailControlSeeder::class,
        ]);

    }
}
