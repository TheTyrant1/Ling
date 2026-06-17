<?php

namespace App\Http\Controllers\Personal\Follow;


class IndexController
{
    public function __invoke()
    {
        $following = auth()->user()
            ->followings()
            ->paginate(10);

       return view('personal::blade.modules.follow.index', compact('following'));
    }
}
