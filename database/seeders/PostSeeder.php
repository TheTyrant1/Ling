<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id');
        $tags = Tag::all();

        Post::factory()
            ->count(200)
            ->create([
                'user_id' => fn() => $userIds->random(),
            ])
            ->each(function ($post) use ($tags) {
                if ($tags->isNotEmpty()) {
                    $post->tags()->attach(
                        $tags->random(rand(1, min(10, $tags->count())))->pluck('id')
                    );
                }
            });
    }
}
