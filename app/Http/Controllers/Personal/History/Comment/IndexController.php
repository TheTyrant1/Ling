<?php

namespace App\Http\Controllers\Personal\History\Comment;

use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Request $request)
    {
        $query = auth()->user()->comments()
            ->withCount(['likes'])
            ->withCount([
                'likes as today_likes_count' => function ($query) {
                    $query->whereDate('comment_user_likes.created_at', today());
                },
            ])
            ->with('post')
            ->whereHas('post');

        $sort = $request->sort ?? 'latest';

        switch ($sort) {
            case 'latest':
                $query->latest();
                break;

            case 'popular':
                $query->orderBy('likes_count', 'desc')
                    ->latest();
                break;
        }

        $comments = $query->paginate(10);

        return view('personal::blade.modules.history.comment.index', compact('comments', 'sort'));
    }
}
