<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'type' => 'income',
                'name' => 'Salary',
                'icon' => 'wallet',
            ],
            [
                'type' => 'income',
                'name' => 'Rental',
                'icon' => 'house',
            ],
            [
                'type' => 'income',
                'name' => 'Grants',
                'icon' => 'hand-coins',
            ],
            [
                'type' => 'income',
                'name' => 'Refunds',
                'icon' => 'refresh-ccw',
            ],
            [
                'type' => 'expense',
                'name' => 'Food',
                'icon' => 'utensils',
            ],
            [
                'type' => 'expense',
                'name' => 'Health',
                'icon' => 'heart-pulse',
            ],
            [
                'type' => 'expense',
                'name' => 'Education',
                'icon' => 'school',
            ],
            [
                'type' => 'expense',
                'name' => 'Clothing',
                'icon' => 'shirt',
            ],
            [
                'type' => 'expense',
                'name' => 'Entertainment',
                'icon' => 'clapperboard',
            ],
            [
                'type' => 'expense',
                'name' => 'Transporation',
                'icon' => 'bus',
            ],
            [
                'type' => 'expense',
                'name' => 'Bills',
                'icon' => 'receipt',
            ],
            [
                'type' => 'expense',
                'name' => 'Rent',
                'icon' => 'house',
            ],
            [
                'type' => 'expense',
                'name' => 'Insurance',
                'icon' => 'bookmark-check',
            ],
        ]);
    }
}
