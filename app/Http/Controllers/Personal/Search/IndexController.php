<?php

namespace App\Http\Controllers\Personal\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('query');
        $user = auth()->user();

        if (!$query) {
            return response()->json([
                'following' => [],
                'views' => [],
                'likes' => [],
                'saves' => [],
                'comments' => [],
                'posts' => [],
                'appeals' => []
            ]);
        }

        $isNumeric = is_numeric($query);

        $following = $user->followings()
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('name', 'ilike', "%{$query}%");
                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }
            })
            ->limit(5)
            ->get()
            ->map(fn($following) => [
                'type' => 'user',
                'title' => Str::limit($following->name, 15),
                'url' => route('user.show', $following),
                'icon' => 'fa-solid fa-users',
                'image' => asset('storage/' . $following->profile_image),
            ]);

        $views = $user->viewedPosts()
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('title', 'ilike', "%{$query}%");
                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }
            })
            ->limit(5)
            ->get()
            ->map(fn($post) => [
                'type' => 'post',
                'title' => Str::limit($post->title, 35),
                'url' => route('personal.history.view.show', $post),
                'icon' => 'fa-solid fa-eye',
                'image' => asset('storage/' . $post->preview_image),
            ]);

        $likes = $user->likedPosts()
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('title', 'ilike', "%{$query}%");
                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }
            })
            ->limit(5)
            ->get()
            ->map(fn($post) => [
                'type' => 'post',
                'title' => Str::limit($post->title, 35),
                'url' => route('personal.history.like.show', $post),
                'icon' => 'fa-solid fa-heart',
                'image' => asset('storage/' . $post->preview_image),
            ]);

        $saves = $user->savedPosts()
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('title', 'ilike', "%{$query}%");
                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }
            })
            ->limit(5)
            ->get()
            ->map(fn($post) => [
                'type' => 'post',
                'title' => Str::limit($post->title, 35),
                'url' => route('personal.history.save.show', $post),
                'icon' => 'fa-solid fa-bookmark',
                'image' => asset('storage/' . $post->preview_image),
            ]);

        $comments = $user->comments()
            ->with('post')
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('message', 'ilike', "%{$query}%");
                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }
            })
            ->limit(5)
            ->get()
            ->map(fn($comment) => [
                'type' => 'comment',
                'title' => Str::limit($comment->message, 25),
                'subtitle' => 'In: ' . Str::limit($comment->post->title ?? 'Post', 35),
                'url' => route('personal.history.comment.show', $comment),
                'icon' => 'fa-solid fa-comment',
            ]);

        $posts = $user->posts()
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('title', 'ilike', "%{$query}%");
                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }
            })
            ->limit(5)
            ->get()
            ->map(fn($post) => [
                'type' => 'post',
                'title' => Str::limit($post->title, 35),
                'url' => route('personal.history.post.show', $post),
                'icon' => 'fa-solid fa-newspaper',
                'image' => asset('storage/' . $post->preview_image),
            ]);

        $appeals = $user->appeals()
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('user_message', 'ilike', "%{$query}%");
                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }
            })
            ->limit(5)
            ->get()
            ->map(fn($appeal) => [
                'type' => 'appeal',
                'title' => Str::limit($appeal->user_message, 25),
                'url' => route('personal.history.appeal.show', $appeal),
                'icon' => 'fa-solid fa-gavel',
            ]);

        return response()->json([
            'following' => $following,
            'views' => $views,
            'likes' => $likes,
            'saves' => $saves,
            'comments' => $comments,
            'posts' => $posts,
            'appeals' => $appeals
        ]);
    }
}
