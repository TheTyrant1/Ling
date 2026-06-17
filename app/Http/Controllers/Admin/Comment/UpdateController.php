<?php

namespace App\Http\Controllers\Admin\Comment;



use App\Http\Requests\Admin\Comment\UpdateRequest;
use App\Models\Comment;

class UpdateController
{
    public function __invoke(UpdateRequest $request, Comment $comment)
    {
        $data = $request->validated();
        $comment->update($data);
        return redirect()->route('admin.comment.show', compact('comment'));
    }
}
