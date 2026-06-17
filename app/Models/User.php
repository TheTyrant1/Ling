<?php

namespace App\Models;

use App\Notifications\SendVerifyWithQueueNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status_id',
        'email_verified_at'
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new SendVerifyWithQueueNotification());
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function viewedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_views', 'user_id', 'post_id')
            ->withTimestamps();
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_likes', 'user_id', 'post_id')
            ->withTimestamps();
    }

    public function savedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_saves', 'user_id', 'post_id')
            ->withTimestamps();
    }

    // The profile made reports to other users
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // The profile received reports from other users
    public function reportsReceived()
    {
        return $this->morphMany(Report::class, 'reportable');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_user_likes', 'user_id', 'comment_id')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    }

    public function isFollowing(User $user): bool
    {
        return $this->followings()
            ->where('following_id', $user->id)
            ->exists();
    }

    public function ban()
    {
        $this->update(['status_id' => 2]);

        $this->posts()->update(['status_id' => 2]);
        $this->comments()->update(['status_id' => 2]);
    }

    public function appeals()
    {
        return $this->hasMany(Appeal::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }
}
