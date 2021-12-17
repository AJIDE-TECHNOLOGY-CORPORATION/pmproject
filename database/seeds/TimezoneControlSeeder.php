<?php

use Illuminate\Database\Seeder;
use App\Timezone;

class TimezoneControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $timestamp = time();
        foreach (timezone_identifiers_list() as $zone) {
            date_default_timezone_set($zone);
            $zones['offset'] = date('P', $timestamp);
            $zones['diff_from_gtm'] = 'UTC/GMT ' . date('P', $timestamp);

            Timezone::updateOrCreate(['name' => $zone], $zones);
            Timezone::updateOrCreate(['name' => 'Indian/Kolkata'], ['offset' => '+05:30', 'diff_from_gtm' => 'UTC/GMT']);

        }
    }
}
