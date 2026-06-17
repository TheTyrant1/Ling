<?php

namespace App\Http\Controllers\Web\Comment;

use App\Http\Requests\Web\Post\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;

class StoreController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['post_id'] = $request->post_id;
        $data['parent_id'] = $request->parent_id;

        $comment = Comment::create($data);

        $post = Post::findOrFail($request->post_id);

        if ($post->user_id !== auth()->id()) {
            Notification::firstOrCreate([
                'user_id' => $post->user_id,
                'from_user_id' => auth()->id(),
                'type' => 'comment',
                'post_id' => $post->id,
                'comment_id' => $comment->id,
            ]);
        }

        return redirect()->route('post.show', $post->id);
    }
}
