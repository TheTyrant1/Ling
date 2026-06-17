<?php

namespace App\Http\Controllers\Admin\Search;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'posts' => [],
                'categories' => [],
                'tags' => [],
                'users' => [],
                'comments' => [],
                'appeals' => []
            ]);
        }

        $posts = Post::withTrashed()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('id', $query)
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")->orWhere('id', $query);
            })
            ->limit(5)
            ->get()
            ->map(fn($post) => [
                'type' => 'post',
                'title' => str($post->title)->limit(35),
                'subtitle' => str($post->user->name ?? 'Unknown')->limit(15),
                'url' => route('admin.post.show', $post->id),
                'icon' => 'fa-solid fa-newspaper',
                'image' => $post->preview_image ? asset('storage/' . $post->preview_image) : null,
                'badge' => 'ID: ' . $post->id
            ]);

        $tags = Tag::withTrashed()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($tag) => [
                'type' => 'tag',
                'title' => str($tag->title)->limit(15),
                'url' => route('admin.tag.show', $tag->id),
                'icon' => 'fa-solid fa-hashtag',
                'badge' => 'ID: ' . $tag->id
            ]);

        $users = User::withTrashed()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($user) => [
                'type' => 'user',
                'title' => str($user->name)->limit(15),
                'url' => route('admin.user.show', $user->id),
                'icon' => 'fa-solid fa-users',
                'image' => $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/profile_images/user_9307950.png'),
                'badge' => 'ID: ' . $user->id
            ]);

        $comments = Comment::withTrashed()
            ->where('message', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%$query%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")->orWhere('id', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(fn($comment) => [
                'type' => 'comment',
                'title' => str($comment->message)->limit(25),
                'subtitle' => str($comment->user->name ?? 'Unknown')->limit(15),
                'url' => route('admin.comment.show', $comment->id),
                'icon' => 'fa-solid fa-comments',
                'badge' => 'ID: ' . $comment->id
            ]);

        $appeals = Appeal::where('user_message', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%$query%")
            ->limit(5)
            ->get()
            ->map(fn($appeal) => [
                'type' => 'appeal',
                'title' => str($appeal->user_message ?? 'No message')->limit(25),
                'subtitle' => 'Moderator: ' . str($appeal->admin_message ?? 'No message')->limit(25),
                'url' => route('admin.appeal.show', $appeal->id),
                'icon' => 'fa-solid fa-gavel',
                'badge' => 'ID: ' . $appeal->id
            ]);

        return response()->json([
            'posts' => $posts,
            'tags' => $tags,
            'users' => $users,
            'comments' => $comments,
            'appeals' => $appeals
        ]);
    }
}
