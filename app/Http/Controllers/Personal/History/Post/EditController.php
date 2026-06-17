<?php

namespace App\Http\Controllers\Personal\History\Post;

use App\Models\Post;
use App\Models\Tag;

class EditController extends BaseController
{
    public function __invoke(Post $post)
    {
        $post->load('tags');

        $tags = Tag::all();

        return view('personal::blade.modules.history.post.edit', compact('post', 'tags'));
    }
}
