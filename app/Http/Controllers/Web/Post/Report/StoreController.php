<?php

namespace App\Http\Controllers\Web\Post\Report;

use App\Models\Notification;
use App\Models\Post;
use App\Models\Report;

class StoreController
{
    public function __invoke(Post $post)
    {
        $user = auth()->user();

        $isReported = auth()->user()
            ->reports()
            ->where('reportable_type', Post::class)
            ->where('reportable_id', $post->id)
            ->exists();

        if ($isReported) {
            return back();
        }

        else {
            Report::create([
                'user_id' => auth()->id(),
                'reportable_type' => Post::class,
                'reportable_id' => $post->id
            ]);
        }

        if ($post->reportsReceived()->count() >= 15) {

            $post->update([
                'status_id' => 2
            ]);

            Notification::firstOrCreate([
                'user_id' => $post->user_id,
                'from_user_id' => null,
                'type' => 'post_reported',
                'post_id' => $post->id,
            ]);
        }


        return back();
    }
}
