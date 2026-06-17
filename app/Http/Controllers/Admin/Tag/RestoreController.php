<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Models\Tag;

class RestoreController
{
    public function __invoke($id)
    {
        $tag = Tag::onlyTrashed()->find($id);

        $tag->restore();

        return redirect()->back();
    }
}
