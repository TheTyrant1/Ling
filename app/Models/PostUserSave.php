<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostUserSave extends Model
{
    protected $guarded = false;
    protected $table = 'post_user_saves';

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
