<?php

namespace App\Http\Controllers\Web\Comment\Like;

use App\Models\Comment;
use App\Models\Notification;

class StoreController
{
    public function __invoke(Comment $comment)
    {
        $user = auth()->user();

        $exists = $user->likedComments()->where('comment_id', $comment->id)->exists();

        if ($exists) {
            $user->likedComments()->detach($comment->id);
            return back();
        }

        $user->likedComments()->attach($comment->id);

        if ($comment->user_id !== $user->id) {
            Notification::firstOrCreate([
                'user_id' => $comment->user_id,
                'from_user_id' => $user->id,
                'type' => 'like',
                'comment_id' => $comment->id,
                'post_id' => $comment->post_id,
            ]);
        }

        return back();
    }
}
