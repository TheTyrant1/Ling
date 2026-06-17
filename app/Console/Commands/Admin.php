<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Admin extends Command
{
    protected $signature = 'make:admin';

    protected $description = 'Create administrator account';

    public function handle(): int
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        if (User::where('email', $email)->exists()) {
            $this->error('User with this email already exists.');

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => 1,
            'email_verified_at' => now()
        ]);

        $this->info('Administrator created successfully.');

        return self::SUCCESS;
    }
}
