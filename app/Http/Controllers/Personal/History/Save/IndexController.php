<?php

namespace App\Http\Controllers\Personal\History\Save;

class IndexController
{
    public function __invoke()
    {
        $posts = auth()->user()->savedPosts()
            ->withCount(['views', 'likes', 'saves'])
            ->withCount([
                'views as today_views_count' => function ($query) {
                    $query->whereDate('post_user_views.created_at', today());
                },
                'likes as today_likes_count' => function ($query) {
                    $query->whereDate('post_user_likes.created_at', today());
                },
                'saves as today_saves_count' => function ($query) {
                    $query->whereDate('post_user_saves.created_at', today());
                }
            ])
            ->latest()
            ->paginate(10);
        return view('personal::blade.modules.history.save.index', compact('posts'));
    }
}
