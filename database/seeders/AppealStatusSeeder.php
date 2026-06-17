<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppealStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appeal_statuses')->insert([
            ['id' => 1, 'name' => 'pending'],
            ['id' => 2, 'name' => 'approved'],
            ['id' => 3, 'name' => 'rejected'],
        ]);
    }
}
