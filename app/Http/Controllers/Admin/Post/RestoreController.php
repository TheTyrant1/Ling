<?php

namespace App\Http\Controllers\Admin\Post;

use App\Models\Post;

class RestoreController extends BaseController
{
    public function __invoke($id)
    {
        $post = Post::onlyTrashed()->find($id);

        $post->restore();

        return redirect()->back();
    }
}
