<?php

namespace App\Http\Controllers\Personal\History\View;

use App\Models\Post;

class DeleteController
{
    public function __invoke(Post $post)
    {
        auth()->user()->viewedPosts()->detach($post->id);

        return redirect()->back();
    }
}
