<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $guarded = false;

    public function reportable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrl()
    {
        return match (true) {
            $this->reportable instanceof \App\Models\User
            => route('profile.show', $this->reportable->id),

            $this->reportable instanceof \App\Models\Post
            => route('post.show', $this->reportable->id),

            $this->reportable instanceof \App\Models\Comment
            => route('post.show', $this->reportable->post_id),
        };
    }

}
