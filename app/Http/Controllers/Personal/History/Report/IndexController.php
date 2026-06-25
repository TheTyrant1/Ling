<?php

namespace App\Http\Controllers\Personal\History\Report;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Request $request)
    {
        $type = $request->input('type', 'user');

        $map = [
            'user'    => User::class,
            'post'    => Post::class,
            'comment' => Comment::class,
        ];

        $modelClass = $map[$type] ?? User::class;

        $query = auth()->user()->reports()->where('reportable_type', $modelClass);

        $query->whereHasMorph('reportable', [$modelClass]);

        $reports = $query->paginate(10);

        return view('personal::blade.modules.history.report.index', compact('reports'));
    }
}
