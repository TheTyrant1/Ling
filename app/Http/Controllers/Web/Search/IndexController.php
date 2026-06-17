<?php

namespace App\Http\Controllers\Web\Search;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'posts' => [],
                'tags' => [],
                'users' => []
            ]);
        }

        $posts = Post::where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%");
        })
            ->where('status_id', 1)
            ->with('tags')
            ->limit(5)
            ->get()
            ->map(function ($post) {
                return [
                    'type' => 'post',
                    'title' => Str::limit($post->title, 35),
                    'url' => route('post.show', $post->id),
                    'image' => $post->preview_image ? asset('storage/' . $post->preview_image) : null,
                    'icon' => 'fa-solid fa-newspaper',
                ];
            });

        $tags = Tag::where('title', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($tag) {
                return [
                    'type' => 'tag',
                    'title' => Str::limit($tag->title, 15),
                    'url' => route('tag.index', $tag->id),
                    'icon' => 'fa-solid fa-hashtag',
                ];
            });

        $users = User::where('name', 'like', "%{$query}%")
            ->where('status_id', 1)
            ->limit(5)
            ->get()
            ->map(fn($user) => [
                'type' => 'user',
                'title' => Str::limit($user->name, 15),
                'url' => route('user.show', $user->id),
                'icon' => 'fa-solid fa-users',
                'image' => $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/profile_images/user_9307950.png'),
            ]);

        return response()->json([
            'posts' => $posts,
            'tags' => $tags,
            'users' => $users
        ]);

    }
}
