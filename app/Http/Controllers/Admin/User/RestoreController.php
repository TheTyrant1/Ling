<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;

class RestoreController
{
    public function __invoke($id)
    {
        $user = User::onlyTrashed()->find($id);

        $user->restore();

        return redirect()->back();
    }
}
