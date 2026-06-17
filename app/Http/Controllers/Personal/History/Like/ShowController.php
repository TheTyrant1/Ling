<?php

namespace App\Http\Controllers\Personal\History\Like;

class ShowController
{
    public function __invoke($id)
    {
        $post = auth()->user()->likedPosts()
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
            ->findOrFail($id);

        return view('personal::blade.modules.history.like.show', compact('post'));
    }
}
