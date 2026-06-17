<?php

namespace App\Policies\Appeal;

use App\Models\User;
use App\Models\Appeal;

class AppealPolicy
{
    public function show(User $user, Appeal $appeal)
    {
        return $user->id === $appeal->user_id;
    }

    public function update(User $user, Appeal $appeal)
    {
        return $user->id === $appeal->user_id;
    }

    public function delete(User $user, Appeal $appeal)
    {
        return $user->id === $appeal->user_id;
    }
}
