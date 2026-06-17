<?php

namespace App\Policies\Tag;

use App\Models\Tag;
use App\Models\User;

class TagPolicy
{
    public function update(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    public function delete(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    public function restore(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }
}
