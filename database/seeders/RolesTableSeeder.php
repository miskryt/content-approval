<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'Super-Admin', 'description' => 'Full access user'],
            ['name' => 'Client', 'description' => 'Owner of the campaign'],
            ['name' => 'Influencer', 'description' => 'Person who does advertising'],
        ];

        foreach ($roles as $role)
        {
            DB::table('roles')->insert(['name' => $role,]);
        }
    }
}
