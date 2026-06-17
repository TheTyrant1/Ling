<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Controllers\Admin\Post\BaseController;
use App\Models\Tag;

class ShowController extends BaseController
{
    public function __invoke($id)
    {
        $tag = Tag::withTrashed()->findOrFail($id);
        return view('admin::blade.modules.tag.show', compact('tag'));
    }
}
