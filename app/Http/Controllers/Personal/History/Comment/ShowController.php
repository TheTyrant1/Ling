<?php

namespace App\Http\Controllers\Personal\History\Comment;

use App\Models\Comment;

class ShowController
{
    public function __invoke($id)
    {
        $comment = Comment::withTrashed()
            ->withCount(['likes'])
            ->withCount([
                'likes as today_likes_count' => function ($query) {
                    $query->whereDate('comment_user_likes.created_at', today());
                },
            ])
            ->findOrFail($id);
        return view('personal::blade.modules.history.comment.show', compact('comment'));
    }
}
