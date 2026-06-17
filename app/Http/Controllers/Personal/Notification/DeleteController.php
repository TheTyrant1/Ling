<?php

namespace App\Http\Controllers\Personal\Notification;


use App\Models\Notification;

class DeleteController
{
    public function __invoke(Notification $notification)
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->delete();

        return redirect()->back();
    }
}
