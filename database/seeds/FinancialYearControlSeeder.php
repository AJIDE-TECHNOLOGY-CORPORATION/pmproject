<?php

use Illuminate\Database\Seeder;
use App\FinancialYear;
use Carbon\Carbon;

class FinancialYearControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = date('Y')-3;

        for($i=0;$i<12;$i++)
        {
            FinancialYear::create([
                'year'=>$year + $i,
                'duration'=>'['.($year + $i) .'-'.($year + $i + 1).']',
                'is_active'=>($year+$i) == date('Y') ? 1 : 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

        }

    }
}
