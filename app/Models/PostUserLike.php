<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostUserLike extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $table = 'post_user_likes';

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
