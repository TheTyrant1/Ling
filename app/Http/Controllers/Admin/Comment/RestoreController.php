<?php

namespace App\Http\Controllers\Admin\Comment;

use App\Models\Comment;

class RestoreController
{
    public function __invoke($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        $comment->restore();

        return redirect()->back();
    }
}
