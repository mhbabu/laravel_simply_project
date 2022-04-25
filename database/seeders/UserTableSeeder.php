<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'System Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'status' => 1,
            'created_at' => Carbon::now()->format('Y-m-d','H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d','H:i:s'),
        ]);
    }
}
