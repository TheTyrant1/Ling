<?php

namespace App\Http\Controllers\Personal\Notification;


use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        $user->notifications()
            ->whereNull('read_at')
            ->update([
                'read_at' => now()
            ]);

        $query = auth()->user()
            ->notifications()
            ->with(['fromUser', 'post', 'comment'])
            ->latest();

        if ($request->type === 'report') {
            $query->whereIn('type', [
                'post_reported',
                'comment_reported',
                'user_reported',
            ]);
        } elseif ($request->type) {
            $query->where('type', $request->type);
        }

        $notifications = $query->paginate(10)->withQueryString();

        return view('personal::blade.modules.notification.index', [
            'notifications' => $notifications,
            'type' => $request->type
        ]);
    }
}
