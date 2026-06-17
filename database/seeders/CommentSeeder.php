<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        Comment::factory(1000)->make()->each(function ($comment) {

            $comment->user_id = User::inRandomOrder()->value('id');
            $comment->post_id = Post::inRandomOrder()->value('id');
            $comment->save();
        });
    }
}
