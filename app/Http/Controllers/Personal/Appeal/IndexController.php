<?php

namespace App\Http\Controllers\Personal\Appeal;

use App\Models\Appeal;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $appeals = Appeal::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('personal::blade.modules.appeal.index', compact('appeals'));
    }
}
