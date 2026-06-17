<?php

namespace App\Http\Controllers\Web\User;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ShowController
{
    public  function __invoke(User $user, Request $request)
    {

        $query = Post::with(['tags'])
            ->withCount(['views', 'likes', 'saves'])
            ->where('user_id', $user->id)
            ->where('status_id', 1);

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

        return view('web::blade.modules.user.show', compact('user','posts', 'sort'));
    }
}
