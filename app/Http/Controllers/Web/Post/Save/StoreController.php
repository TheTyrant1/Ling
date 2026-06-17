<?php

namespace App\Http\Controllers\Web\Post\Save;


use App\Models\Notification;
use App\Models\Post;

class StoreController
{
    public function __invoke(Post $post)
    {
        $user = auth()->user();

        if ($user->savedPosts()->where('post_id', $post->id)->exists()) {
            $user->savedPosts()->detach($post->id);
        }
        else {
            $user->savedPosts()->attach($post->id, ['created_at' => now(), 'updated_at' => now()]);
        }
        if ($post->user_id !== $user->id) {
            Notification::firstOrCreate([
                'user_id' => $post->user_id,
                'from_user_id' => $user->id,
                'type' => 'save',
                'post_id' => $post->id,
            ]);
        }

        return back();
    }
}
