<?php

namespace App\Http\Controllers\Personal\Trash\Post;

use App\Models\Post;

class MassiveDeleteController extends BaseController
{
    public function __invoke()
    {
        auth()->user()->posts()->onlyTrashed()->forceDelete();

        return redirect()->back();

    }
}
