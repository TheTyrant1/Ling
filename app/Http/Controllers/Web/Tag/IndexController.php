<?php

namespace App\Http\Controllers\Web\Tag;

use App\Models\Tag;
use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Tag $tag, Request $request)
    {
        $sort = $request->sort ?? 'latest';

        $query = $tag->posts()
            ->with(['tags'])
            ->where('status_id', '1')
            ->withCount(['views', 'likes', 'saves']);

        switch($sort) {

            case 'latest':
                $query->latest();
                break;

            case 'popular':
                $query->orderBy('likes_users_count', 'desc');
                break;
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('web::blade.modules.tag.index', compact('tag', 'posts', 'sort'));
    }
}
