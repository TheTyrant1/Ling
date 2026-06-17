<?php

namespace App\Http\Controllers\Personal\Appeal;

use App\Models\Appeal;

class EditController extends BaseController
{
    public function __invoke(Appeal $appeal)
    {
        $this->authorize('update', $appeal);

        return view('personal::blade.modules.appeal.edit', compact('appeal'));
    }
}
