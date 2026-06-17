<?php

namespace App\Http\Controllers\Personal\History;

use App\Models\Appeal;

class IndexController
{
    public function __invoke()
    {
        $data = [];

        $data['viewsCount'] = auth()->user()->viewedPosts()->count();
        $data['viewsToday'] = auth()->user()->viewedPosts()->whereDate('post_user_views.created_at', today())->count();

        $data['likesCount'] = auth()->user()->likedPosts()->count();
        $data['likesToday'] = auth()->user()->likedPosts()->whereDate('post_user_likes.created_at', today())->count();

        $data['savesCount'] = auth()->user()->savedPosts()->count();
        $data['savesToday'] = auth()->user()->savedPosts()->whereDate('post_user_saves.created_at', today())->count();

        $data['commentsCount'] = auth()->user()->comments()->count();
        $data['commentsToday'] = auth()->user()->comments()->whereDate('created_at', today())->count();

        $data['postsCount'] = auth()->user()->posts()->count();
        $data['postsToday'] = auth()->user()->posts()->whereDate('created_at', today())->count();

        $data['appealsCount'] = auth()->user()->appeals()->count();
        $data['appealsToday'] = auth()->user()->appeals()->whereDate('created_at', today())->count();

        $data['reportsCount'] = auth()->user()->reports()->count();
        $data['reportsToday'] = auth()->user()->reports()->whereDate('created_at', today())->count();

        return view('personal::blade.modules.history.index', compact('data'));
    }
}
