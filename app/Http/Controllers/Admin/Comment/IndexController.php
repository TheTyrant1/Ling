<?php

namespace App\Http\Controllers\Admin\Comment;

use App\Models\Comment;
use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Request $request)
    {
        $query = Comment::withTrashed()
            ->with(['user', 'post', 'parent.user'])
            ->whereHas('post')
            ->withCount('likes')
            ->withCount([
                'likes as today_likes_count' => function ($query) {
                    $query->whereDate('comment_user_likes.created_at', today());
                },
            ]);
        $sort = $request->sort ?? 'latest';

        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'popular':
                $query->orderBy('likes_count', 'desc');
                break;
        }

        $comments = $query->paginate(9)->withQueryString();

        return view('admin::blade.modules.comment.index', compact('comments', 'sort'));
    }
}
