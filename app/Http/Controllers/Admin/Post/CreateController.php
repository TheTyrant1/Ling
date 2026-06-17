<?php

namespace App\Http\Controllers\Admin\Post;

use App\Models\Post;

class CreateController extends BaseController
{
    public function __invoke()
    {
        return view('admin::blade.modules.post.create');
    }
}
