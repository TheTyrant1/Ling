<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;

class IndexController
{
    public function __invoke()
    {
        $users = User::withTrashed()->latest()->paginate(10);
        return view('admin::blade.modules.user.index', compact('users'));
    }
}
