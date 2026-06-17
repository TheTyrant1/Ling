<?php

namespace App\Http\Controllers\Personal\Profile;


class EditController
{
    public function __invoke()
    {
        $user = auth()->user();
        return view('personal::blade.modules.profile.edit', compact('user'));
    }
}
