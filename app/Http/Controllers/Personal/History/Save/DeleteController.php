<?php

namespace App\Http\Controllers\Personal\History\Save;

use App\Models\Post;

class DeleteController
{
    public function __invoke(Post $post)
    {
        auth()->user()->savedPosts()->detach($post->id);

        return redirect()->back();
    }
}
