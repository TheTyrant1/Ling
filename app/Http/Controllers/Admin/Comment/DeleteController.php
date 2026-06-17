<?php

namespace App\Http\Controllers\Admin\Comment;



use App\Models\Comment;

class DeleteController
{
    public function __invoke(Comment $comment)
    {
        $comment->delete();
        return redirect()->back();
    }
}
