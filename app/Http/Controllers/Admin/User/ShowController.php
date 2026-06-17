<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;


class ShowController
{
    public function __invoke($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('admin::blade.modules.user.show', compact('user'));
    }
}
