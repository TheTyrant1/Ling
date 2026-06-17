<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Role;
use App\Models\User;

class EditController
{
    public function __invoke(User $user)
    {
        $roles = Role::all();
        return view('admin::blade.modules.user.edit', compact('user', 'roles'));
    }
}
