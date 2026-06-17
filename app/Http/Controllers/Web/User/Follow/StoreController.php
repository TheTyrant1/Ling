<?php

namespace App\Http\Controllers\Web\User\Follow;

use App\Models\Notification;
use App\Models\User;

class StoreController
{
    public function __invoke(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->id === $user->id) {
            abort(403);
        }

        $result = $authUser->followings()->toggle($user->id);

        if (!empty($result['attached'])) {
            Notification::firstOrCreate([
                'user_id' => $user->id,
                'from_user_id' => $authUser->id,
                'type' => 'follow',
            ]);
        }

        return back();
    }
}
