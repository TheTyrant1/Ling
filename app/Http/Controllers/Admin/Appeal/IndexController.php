<?php

namespace App\Http\Controllers\Admin\Appeal;

use App\Models\Appeal;

class IndexController
{
    public function __invoke()
    {
        $appeals = Appeal::latest()->paginate(10);

        return view('admin::blade.modules.appeal.index', compact('appeals'));
    }
}
