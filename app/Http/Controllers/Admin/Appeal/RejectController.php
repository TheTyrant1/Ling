<?php

namespace App\Http\Controllers\Admin\Appeal;

use App\Models\Appeal;

class RejectController
{
    public function __invoke(Appeal $appeal)
    {
        $appeal->update([
            'status_id' => 3
        ]);

        return redirect()->back();
    }
}
