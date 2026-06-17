<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appeal extends Model
{
    use SoftDeletes;

    protected $table = 'appeals';
    protected $guarded = false;

    protected $casts = [
        'user_updated_at' => 'datetime',
        'admin_updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::updating(function ($appeal) {
            if (
                $appeal->isDirty('status_id') ||
                $appeal->isDirty('admin_message')
            ) {
                $appeal->admin_updated_at = now();
            }

            if (
                $appeal->isDirty('type_id') ||
                $appeal->isDirty('user_message')
            ) {
                $appeal->user_updated_at = now();
            }
        });
    }
}
