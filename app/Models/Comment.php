<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Termwind\parse;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'comments';
    protected $guarded = false;

    protected $withCount = ['likes'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getDateAsCarbonAttribute()
    {
        return Carbon::parse($this->created_at);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with(['user', 'replies.user']);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'comment_user_likes', 'comment_id', 'user_id')->withTimestamps();
    }

    public function reportsReceived()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    protected static function booted()
    {
        static::deleted(function ($comment) {

            Notification::where('comment_id', $comment->id)->delete();

            $childComments = Comment::where('parent_id', $comment->id)->pluck('id');

            Notification::whereIn('comment_id', $childComments)->delete();
        });
    }
}
