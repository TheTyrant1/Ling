<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostUserView extends Model
{
    protected $table = 'post_user_views';
    protected $fillable = ['post_id', 'user_id', 'ip'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
