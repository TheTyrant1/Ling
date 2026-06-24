<?php

namespace App\Http\Controllers\Personal\Trash\Post;

use App\Models\Post;

class ForceDeleteController extends BaseController
{
    public function __invoke(Post $post)
    {
        $this->authorize('forceDelete', $post);

        $post->forceDelete();

        return redirect()->back();
    }
}
