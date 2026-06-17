<?php

namespace App\Http\Controllers\Personal\Post;

use App\Models\Post;
use App\Models\Tag;

class EditController
{
    public function __invoke(Post $post)
    {
        $post->load('tags');

        $tags = Tag::all();

        return view('personal::blade.modules.post.edit', compact('post', 'tags'));
    }
}
