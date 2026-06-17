<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = \App\Models\User::pluck('id');
        $tags = Tag::all();

        Post::factory()
            ->count(200)
            ->make()
            ->each(function ($post) use ($tags, $userIds) {
                $post->user_id = $userIds->random();
                $post->save();

                if ($tags->isNotEmpty()) {
                    $post->tags()->attach(
                        $tags->random(rand(1, min(10, $tags->count())))->pluck('id')
                    );
                }
            });
    }
}
