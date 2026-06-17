<?php

namespace App\Http\Controllers\Admin\Appeal;

use App\Models\Appeal;

class ApproveController
{
    public function __invoke(Appeal $appeal)
    {
        $appeal->update([
            'status_id' => 2
        ]);

        return redirect()->back();
    }
}
