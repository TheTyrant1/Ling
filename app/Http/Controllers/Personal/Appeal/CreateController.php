<?php

namespace App\Http\Controllers\Personal\Appeal;

class CreateController
{
    public function __invoke()
    {
        return view('personal::blade.modules.appeal.create');
    }
}
