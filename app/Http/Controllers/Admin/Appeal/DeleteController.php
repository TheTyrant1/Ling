<?php

namespace App\Http\Controllers\Admin\Appeal;

use App\Models\Appeal;

class DeleteController
{
    public function __invoke(Appeal $appeal)
    {
        $appeal->delete();

        return redirect()->back();
    }
}
