<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sts = [
            ['name' => 'New'],
            ['name' => 'Review in progress'],
            ['name' => 'Agency reviewed'],
            ['name' => 'Approved'],
            ['name' => 'Rejected'],
        ];

        foreach ($sts as $st)
        {
            DB::table('asset_statuses')->insert(['name' => $st]);
        }
    }
}
