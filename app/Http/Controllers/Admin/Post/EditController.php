<?php

namespace App\Http\Controllers\Admin\Post;

use App\Models\Post;
use App\Models\Tag;

class EditController extends BaseController
{
    public function __invoke(Post $post)
    {
        $tags = Tag::all();
        return view('admin::blade.modules.post.edit', compact('post', 'tags'));
    }
}
