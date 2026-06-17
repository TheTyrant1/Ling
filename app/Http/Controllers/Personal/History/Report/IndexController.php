<?php

namespace App\Http\Controllers\Personal\History\Report;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Request $request)
    {
        $query = auth()->user()->reports();

        $type = $request->type ?? 'user';

        switch ($type) {
            case 'post':
                $query->where('reportable_type', Post::class);
                break;

            case 'comment':
                $query->where('reportable_type', Comment::class);
                break;

            default:
                $query->where('reportable_type', User::class);
                break;
        }

        $reports = $query->paginate(10);

        return view('personal::blade.modules.history.report.index', compact('reports'));
    }
}
