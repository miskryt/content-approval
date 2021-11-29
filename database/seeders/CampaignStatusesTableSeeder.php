<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sts = [
            ['name' => 'Active'],
            ['name' => 'Draft'],
            ['name' => 'Ended'],
            ['name' => 'Recruiting'],
        ];

        foreach ($sts as $st)
        {
            DB::table('campaign_statuses')->insert(['name' => $st]);
        }
    }
}
