<?php

namespace App\Http\Controllers\Personal\Trash\Post;

use App\Http\Controllers\Personal\Post\BaseController;
use App\Models\Post;

class RestoreController extends BaseController
{
    public function __invoke($id)
    {
        $post = Post::onlyTrashed()->find($id);

        $this->authorize('restore', $post);

        $post->restore();

        return redirect()->back();
    }
}
