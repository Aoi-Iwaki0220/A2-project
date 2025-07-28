<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                'name' => 'おかし',
                'category_type' => 1,
            ],
            [
                'name' => 'おしゃれ',
                'category_type' => 1,
            ],
            [
                'name' => 'そのた',
                'category_type' => 1,
            ],
            [
                'name' => 'おこづかい',
                'category_type' => 0,
            ],
        ];
        DB::table('types')->insert($params);
    }
}
