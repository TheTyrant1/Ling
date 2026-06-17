<?php

namespace App\Http\Controllers\Personal\History\Like;

use App\Models\Post;

class DeleteController
{
    public function __invoke(Post $post)
    {
        auth()->user()->likedPosts()->detach($post->id);

        return redirect()->back();
    }
}
