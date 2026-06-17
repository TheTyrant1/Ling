<?php

namespace App\Http\Controllers\Personal\Post;

class CreateController
{
    public function __invoke()
    {
        return view('personal::blade.modules.post.create');
    }
}
