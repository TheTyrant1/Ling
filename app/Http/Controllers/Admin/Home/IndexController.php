<?php

namespace App\Http\Controllers\Admin\Home;

use App\Models\Appeal;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;

class IndexController
{
    public function __invoke()
    {
        $data = [];

        $data['postsCount'] = Post::count();
        $data['postsToday'] = Post::whereDate('created_at', today())->count();

        $data['tagsCount']= Tag::count();
        $data['tagsToday'] = Tag::whereDate('created_at', today())->count();

        $data['usersCount'] = User::count();
        $data['usersToday'] = User::whereDate('created_at', today())->count();

        $data['commentsCount'] = Comment::count();
        $data['commentsToday'] = Comment::whereDate('created_at', today())->count();

        $data['appealsCount'] = Appeal::count();
        $data['appealsToday'] = Appeal::whereDate('created_at', today())->count();

        return view('admin::blade.modules.home.index', compact('data'));
    }
}
