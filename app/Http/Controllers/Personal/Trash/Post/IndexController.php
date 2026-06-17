<?php

namespace App\Http\Controllers\Personal\Trash\Post;

use App\Models\Post;
use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Request $request)
    {
        $query = Post::onlyTrashed()
            ->with(['tags'])
            ->where('user_id', auth()->id())
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
            ]);

        $sort = $request->sort ?? 'latest';

        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc')
                    ->orderBy('likes_count', 'desc')
                    ->orderBy('saves_count', 'desc');
                break;
        }

        $posts = $query->paginate(9)->withQueryString();


        return view('personal::blade.modules.trash.index', compact('posts', 'sort'));
    }
}
