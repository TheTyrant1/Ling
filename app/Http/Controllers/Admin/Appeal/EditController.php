<?php

namespace App\Http\Controllers\Admin\Appeal;

use App\Models\Appeal;

class EditController
{
    public  function __invoke(Appeal $appeal)
    {
        return view('admin::blade.modules.appeal.edit', compact('appeal'));
    }
}
