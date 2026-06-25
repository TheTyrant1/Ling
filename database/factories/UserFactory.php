<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'profile_image' => 'factory/images/profile_images/' . $this->faker->randomElement([
                    '6GGJT95lmLqbirr5fCezYkOJeURW0Q9YhlwbtsXI.jpg',
                    'Emg5qwLdPG9ODWuNK35hUbUg52sQNns5uYm1QyuI.jpg',
                    '0f6894e539589a50809e45833c8bb6c4.jpg',
                ]),
            'role_id' => 2,
        ];
    }
}
