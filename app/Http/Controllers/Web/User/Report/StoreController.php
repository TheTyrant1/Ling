<?php

namespace App\Http\Controllers\Web\User\Report;

use App\Models\Notification;
use App\Models\Report;
use App\Models\User;

class StoreController
{
    public function __invoke(User $user)
    {
        if (!auth()->check()) {
            return back();
        }

        if (auth()->id() === $user->id) {
            return back();
        }

        $isReported = auth()->user()
            ->reports()
            ->where('reportable_type', User::class)
            ->where('reportable_id', $user->id)
            ->exists();

        if ($isReported) {
            return back();
        }

        else {
            Report::create([
                'user_id' => auth()->id(),
                'reportable_type' => User::class,
                'reportable_id' => $user->id
            ]);
        }

        if ($user->reportsReceived()->count() >= 1) {
            $user->ban();

            Notification::create([
                'user_id' => $user->id,
                'from_user_id' => null,
                'type' => 'user_reported',
            ]);
        }

        return back();

    }
}
