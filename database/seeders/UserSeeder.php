<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Testing Account',
                'email' => 'test@gmail.com',
                'password' => bcrypt('a1b2c3d4D!'),
                'role' => 'user',
            ],
            [
                'name' => 'Admin Account',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('a1b2c3d4D!'),
                'role' => 'admin',
            ],
        ]);
    }
}
