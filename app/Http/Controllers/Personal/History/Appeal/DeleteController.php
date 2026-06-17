<?php

namespace App\Http\Controllers\Personal\History\Appeal;

use App\Models\Appeal;

class DeleteController extends BaseController
{
    public function __invoke(Appeal $appeal)
    {
        $this->authorize('delete', $appeal);

        $appeal->delete();

        return redirect()->back();
    }
}
