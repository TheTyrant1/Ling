<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Models\Tag;

class IndexController
{
    public function __invoke()
    {
        $tags = Tag::withTrashed()
            ->latest()
            ->paginate(10);
        return view('admin::blade.modules.tag.index', compact('tags'));
    }
}
