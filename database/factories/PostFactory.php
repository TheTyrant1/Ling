<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $images = [
            'factory/images/posts/geforce-rtx-40-series-new.jpeg',
            'factory/images/posts/H3pYnm9aJFwpybezvXhYBLtm4TiRjZiXCrGtxTWh.jpg',
            'factory/images/posts/sPp1XxAOt1iwDfTHKLuSfXqR6J3cxuOcoSpXskQu.jpg',
            'factory/images/posts/YdiTmkRbiuHkaEDSiPQkLQ-650-80.jpg',
            'factory/images/posts/1401539.jpg',
            'factory/images/posts/1749809134849.jpg',
            'factory/images/posts/WSiwdkFwlkfawfsFWf.jpg',
            'factory/images/posts/Wafoapfaofiowjaijwlklaf.jpg',
        ];

        return [
            'title' => fake()->sentence(),
            'content' => fake()->text(500),

            'preview_image' => fake()->randomElement($images),
            'main_image' => fake()->randomElement($images),
        ];
    }
}
