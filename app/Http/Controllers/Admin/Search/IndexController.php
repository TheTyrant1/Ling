<?php

namespace App\Http\Controllers\Admin\Search;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use App\Models\Comment;
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
                'categories' => [],
                'tags' => [],
                'users' => [],
                'comments' => [],
                'appeals' => []
            ]);
        }

        $isNumeric = is_numeric($query);

        $posts = Post::withTrashed()
            ->with('user')
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('title', 'ilike', "%{$query}%");

                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }

                $q->orWhereHas('user', function ($subQ) use ($query, $isNumeric) {
                    $subQ->where('name', 'ilike', "%{$query}%");

                    if ($isNumeric) {
                        $subQ->orWhere('id', $query);
                    }
                });
            })
            ->limit(5)
            ->get()
            ->map(fn($post) => [
                'type' => 'post',
                'title' => Str::limit($post->title, 35),
                'subtitle' => Str::limit($post->user->name ?? 'Unknown', 15),
                'url' => route('admin.post.show', $post),
                'icon' => 'fa-solid fa-newspaper',
                'image' => Storage::url($post->preview_image),
                'badge' => 'ID: ' . $post->id
            ]);

        $tags = Tag::withTrashed()
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('title', 'ilike', "%{$query}%");
                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }
            })
            ->limit(5)
            ->get()
            ->map(fn($tag) => [
                'type' => 'tag',
                'title' => Str::limit($tag->title, 15),
                'url' => route('admin.tag.show', $tag),
                'icon' => 'fa-solid fa-hashtag',
                'badge' => 'ID: ' . $tag->id
            ]);

        $users = User::withTrashed()
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('name', 'ilike', "%{$query}%");
                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }
            })
            ->limit(5)
            ->get()
            ->map(fn($user) => [
                'type' => 'user',
                'title' => Str::limit($user->name, 15),
                'url' => route('admin.user.show', $user),
                'icon' => 'fa-solid fa-users',
                'image' => Storage::url($user->profile_image),
                'badge' => 'ID: ' . $user->id
            ]);

        $comments = Comment::withTrashed()
            ->with('user')
            ->where(function ($q) use ($query, $isNumeric) {
                $q->where('message', 'ilike', "%{$query}%");

                if ($isNumeric) {
                    $q->orWhere('id', $query);
                }

                $q->orWhereHas('user', function ($subQ) use ($query, $isNumeric) {
                    $subQ->where('name', 'ilike', "%{$query}%");
                    if ($isNumeric) {
                        $subQ->orWhere('id', $query);
                    }
                });
            })
            ->limit(5)
            ->get()
            ->map(fn($comment) => [
                'type' => 'comment',
                'title' => Str::limit($comment->message, 25),
                'subtitle' => Str::limit($comment->user->name ?? 'Unknown', 15),
                'url' => route('admin.comment.show', $comment),
                'icon' => 'fa-solid fa-comments',
                'badge' => 'ID: ' . $comment->id
            ]);

        $appeals = Appeal::where(function ($q) use ($query, $isNumeric) {
            $q->where('user_message', 'ilike', "%{$query}%");
            if ($isNumeric) {
                $q->orWhere('id', $query);
            }
        })
            ->limit(5)
            ->get()
            ->map(fn($appeal) => [
                'type' => 'appeal',
                'title' => Str::limit($appeal->user_message ?? 'No message', 25),
                'subtitle' => 'Moderator: ' . Str::limit($appeal->admin_message ?? 'No message', 25),
                'url' => route('admin.appeal.show', $appeal),
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
