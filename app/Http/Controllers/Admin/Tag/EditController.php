<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Models\Tag;

class EditController
{
    public function __invoke(Tag $tag)
    {
        return view('admin::blade.modules.tag.edit', compact('tag'));
    }
}
