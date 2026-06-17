<?php

namespace App\Http\Controllers\Admin\Comment;

use App\Http\Controllers\Admin\Post\BaseController;
use App\Models\Comment;

class ShowController extends BaseController
{
    public function __invoke($id)
    {
        $comment = Comment::withTrashed()
            ->withCount([
                'likes as today_likes_count' => function ($query) {
                    $query->whereDate('comment_user_likes.created_at', today());
                },
            ])
            ->findOrFail($id);
        return view('admin::blade.modules.comment.show', compact('comment'));
    }
}
