<?php

namespace App\Http\Controllers\Admin\Comment;

use App\Models\Comment;

class EditController
{
    public function __invoke(Comment $comment)
    {
        return view('admin::blade.modules.comment.edit', compact('comment'));
    }
}
