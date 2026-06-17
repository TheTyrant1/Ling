<?php

namespace App\Console\Commands;

use App\Models\Appeal;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('cleanup:appeals')]
#[Description('Delete appeals that have been created for more than 30 days')]
class CleanupAppeals extends Command
{
    public function handle()
    {
        Appeal::where('created_at', '<', now()->subDays(30))
            ->orderBy('id')
            ->chunkById(100, function ($appeals) {
                foreach ($appeals as $appeal) {
                    $appeal->forceDelete();
                }
            });
    }
}
