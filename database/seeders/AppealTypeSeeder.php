<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appeal_types')->insert([
            ['id' => 1, 'name' => 'user'],
            ['id' => 2, 'name' => 'post'],
            ['id' => 3, 'name' => 'comment'],
        ]);
    }
}
