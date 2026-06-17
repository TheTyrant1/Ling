<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            StatusSeeder::class,
            AppealStatusSeeder::class,
            AppealTypeSeeder::class,
            UserSeeder::class,
            PostSeeder::class,
            TagSeeder::class,
            CommentSeeder::class
        ]);
    }
}
