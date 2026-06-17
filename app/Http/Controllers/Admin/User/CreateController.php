<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Role;

class CreateController
{
    public function __invoke()
    {
        $roles = Role::all();
        return view('admin::blade.modules.user.create', compact('roles'));
    }
}
