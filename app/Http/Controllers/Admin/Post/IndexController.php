<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $sort = $request->input('sort', 'latest');

        $query = Post::withTrashed()
            ->with(['tags', 'user'])
            ->whereHas('user')
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

        if ($sort === 'popular') {
            $query->orderByDesc('views_count')
                ->orderByDesc('likes_count')
                ->orderByDesc('saves_count');
        } else {
            $query->latest();
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('admin::blade.modules.post.index', compact('posts', 'sort'));
    }
}
