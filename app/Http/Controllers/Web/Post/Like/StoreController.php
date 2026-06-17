<?php

namespace App\Http\Controllers\Web\Post\Like;

use App\Models\Notification;
use App\Models\Post;

class StoreController
{
    public function __invoke(Post $post)
    {
        $user = auth()->user();

        if ($user->likedPosts()->where('post_id', $post->id)->exists()) {
            $user->likedPosts()->detach($post->id);
        } else {
            $user->likedPosts()->attach($post->id, ['created_at' => now(), 'updated_at' => now()]);
        }
        if ($post->user_id !== $user->id){
            Notification::firstOrCreate([
                'user_id' => $post->user_id,
                'from_user_id' => $user->id,
                'type' => 'like',
                'post_id' => $post->id,
            ]);
        }

        return back();
    }
}
