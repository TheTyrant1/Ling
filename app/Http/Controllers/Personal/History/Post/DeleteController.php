<?php

namespace App\Http\Controllers\Personal\History\Post;

use App\Models\Post;

class DeleteController extends BaseController
{
    public function __invoke(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->back();
    }
}
