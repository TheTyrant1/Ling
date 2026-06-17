<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'posts';
    protected $guarded = false;

    protected $casts = [
        'admin_updated_at' => 'datetime',
        'user_updated_at' => 'datetime'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function views()
    {
        return $this->hasMany(PostUserView::class, 'post_id', 'id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_user_likes', 'post_id', 'user_id')
            ->withTimestamps()
            ->withPivot('created_at');
    }

    public function saves()
    {
        return $this->belongsToMany(User::class, 'post_user_saves', 'post_id', 'user_id')
            ->withTimestamps()
            ->withPivot('created_at');
    }

    public function reportsReceived()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    protected static function booted()
    {
        static::deleted(function ($post) {
            Notification::where('post_id', $post->id)->delete();
        });

        static::updating(function ($post) {
            if (
                $post->isDirty('status_id')
            ) {
                $post->admin_updated_at = now();
            }

            if (
                $post->isDirty('title') ||
                $post->isDirty('content') ||
                $post->isDirty('preview_image') ||
                $post->isDirty('main_image')
            ) {
                $post->user_updated_at = now();
            }
        });
    }
}
