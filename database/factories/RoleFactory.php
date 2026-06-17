<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'title' => 'user',
        ];
    }


    public function admin(): static
    {
        return $this->state(fn () => [
            'id' => 1,
            'title' => 'admin',
        ]);
    }

    public function user(): static
    {
        return $this->state(fn () => [
            'id' => 2,
            'title' => 'user',
        ]);
    }
}
