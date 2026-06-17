<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('cleanup:trashed-posts')]
#[Description('Delete posts that have been in trash for more than 30 days')]
class CleanupTrashedPosts extends Command
{
    public function handle()
    {
        Post::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(30))
            ->orderBy('id')
            ->chunkById(100, function ($posts) {
                foreach ($posts as $post) {
                    $post->forceDelete();
                }
            });
    }
}
