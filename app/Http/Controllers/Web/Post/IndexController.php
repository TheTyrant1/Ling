<?php

namespace App\Http\Controllers\Web\Post;

use App\Models\Post;
use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Request $request)
    {
        $query = Post::with([
            'tags',
            'user'
        ])
            ->where('status_id', '1')
            ->withCount(['views', 'likes', 'saves']);

        if (auth()->check()) {
            $userId = auth()->id();

            $query->withExists([
                'likes as is_liked' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                },
                'saves as is_saved' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                },
                'reportsReceived as is_reported' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                }
            ]);
        }

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

        return view('web::blade.modules.post.index', compact('posts', 'sort'));
    }
}
