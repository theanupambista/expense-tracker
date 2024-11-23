<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        DB::table('accounts')->insert([
            [
                'name' => 'Saving',
                'user_id' => $user->id,
                'icon' => 'piggy-bank',
            ]
        ]);
    }
}
