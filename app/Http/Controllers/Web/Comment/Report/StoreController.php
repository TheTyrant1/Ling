<?php

namespace App\Http\Controllers\Web\Comment\Report;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Report;

class StoreController
{
    public function __invoke(Comment $comment)
    {
        if (!auth()->check()) {
            return back();
        }

        if (auth()->id() === $comment->user_id) {
            return back();
        }

        $isReported = auth()->user()
            ->reports()
            ->where('reportable_type', Comment::class)
            ->where('reportable_id', $comment->id)
            ->exists();

        if ($isReported) {
            return back();
        }

        else {
            Report::create([
                'user_id' => auth()->id(),
                'reportable_type' => Comment::class,
                'reportable_id' => $comment->id
            ]);
        }

        if ($comment->reportsReceived()->count() >= 15) {
            $comment->update([
                'status_id' => 2
            ]);

            Notification::firstOrCreate([
                'user_id' => $comment->user_id,
                'from_user_id' => null,
                'type' => 'comment_reported',
                'post_id' => $comment->post->id,
                'comment_id' => $comment->id,
            ]);
        }

        return back();
    }
}
