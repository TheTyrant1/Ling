<?php

namespace App\Http\Controllers\Personal\Appeal;

use App\Models\Appeal;

class ShowController extends BaseController
{
    public function __invoke(Appeal $appeal)
    {
        $this->authorize('show', $appeal);

        return view('personal::blade.modules.appeal.show', compact('appeal'));
    }
}
