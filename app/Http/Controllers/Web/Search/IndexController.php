<?php

namespace App\Http\Controllers\Web\Search;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->map(fn($post) => [
                'type' => 'post',
                'title' => Str::limit($post->title, 35),
                'url' => route('post.show', $post),
                'image' => Storage::url($post->preview_image),
                'icon' => 'fa-solid fa-newspaper',
            ]);

        $tags = Tag::where('title', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($tag) => [
                'type' => 'tag',
                'title' => Str::limit($tag->title, 15),
                'url' => route('tag.index', $tag),
                'icon' => 'fa-solid fa-hashtag',
            ]);

        $users = User::where('name', 'like', "%{$query}%")
            ->where('status_id', 1)
            ->limit(5)
            ->get()
            ->map(fn($user) => [
                'type' => 'user',
                'title' => Str::limit($user->name, 15),
                'url' => route('user.show', $user),
                'icon' => 'fa-solid fa-users',
                'image' => Storage::url($user->profile_image),
            ]);

        return response()->json([
            'posts' => $posts,
            'tags' => $tags,
            'users' => $users
        ]);
    }
}
