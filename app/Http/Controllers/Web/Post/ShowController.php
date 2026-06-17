<?php

namespace App\Http\Controllers\Web\Post;

use App\Jobs\StorePostView;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowController
{
    public function __invoke(Post $post, Request $request)
    {
        $post->loadCount(['views', 'likes', 'saves', 'comments']);

        $commentsQuery = $post->comments()
            ->whereNull('parent_id')
            ->with([
                'user',
                'replies' => function ($q) {
                    $q->where('status_id', 1)
                        ->with([
                            'user',
                            'replies' => fn($q) => $q->where('status_id', 1)->with('user')
                        ]);
                }
            ])
            ->withCount('likes')
            ->where('status_id', 1);

        $sort = $request->get('sort', 'latest');

        if ($sort === 'popular') {
            $commentsQuery->orderBy('likes_count', 'desc');
        } else {
            $commentsQuery->latest();
        }

        $comments = $commentsQuery->paginate(10)->withQueryString();

        $tagIds = $post->tags->pluck('id');

        $relatedPosts = Post::whereHas('tags', function ($q) use ($tagIds) {
            $q->whereIn('tags.id', $tagIds);
        })
            ->where('id', '!=', $post->id)
            ->where('status_id', '1')
            ->with(['tags'])
            ->withCount(['views', 'likes', 'saves'])
            ->limit(3)
            ->get();


        $date = Carbon::parse($post->created_at);

        $viewerIdentifier = auth()->id() ?? request()->ip();
        $key = 'post_' . $post->id . '_viewer_' . md5($viewerIdentifier);

        if (!cache()->has($key)) {
            StorePostView::dispatch($post->id, auth()->id(), request()->ip());
            cache()->put($key, true, 86400);
        }

        return view('web::blade.modules.post.show', compact('post', 'comments', 'relatedPosts', 'date', 'sort'));
    }
}
