<?php

namespace App\Http\Controllers\Personal\History\Appeal;

use App\Models\Appeal;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $appeals = Appeal::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('personal::blade.modules.history.appeal.index', compact('appeals'));
    }
}
