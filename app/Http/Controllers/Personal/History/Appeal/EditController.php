<?php

namespace App\Http\Controllers\Personal\History\Appeal;

use App\Models\Appeal;

class EditController extends BaseController
{
    public function __invoke(Appeal $appeal)
    {
        $this->authorize('update', $appeal);

        return view('personal::blade.modules.history.appeal.edit', compact('appeal'));
    }
}
