<?php

namespace App\Http\Controllers\Admin\Appeal;

use App\Models\Appeal;

class ShowController
{
    public function __invoke(Appeal $appeal)
    {
        return view('admin::blade.modules.appeal.show', compact('appeal'));
    }
}
