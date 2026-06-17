<?php

namespace App\Jobs;

use App\Models\PostUserView;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StorePostView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $postId;
    public $userId;
    public $ip;

    // Конструктор — сначала обязательный $postId, потом $userId и $ip

    public function __construct($postId, $userId = null, $ip = null)
    {
        $this->postId = $postId;
        $this->userId = $userId;
        $this->ip = $ip;
    }

    public function handle()
    {
        PostUserView::create([
            'post_id' => $this->postId,
            'user_id' => $this->userId,
            'ip' => $this->ip,
        ]);
    }
}
