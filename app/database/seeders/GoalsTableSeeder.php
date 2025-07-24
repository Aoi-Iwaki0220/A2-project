<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('goals')->insert([
            'amount' => 1000,
            'date' => '2025-7-25',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' =>Carbon::now(),
        ]);
    }
}
