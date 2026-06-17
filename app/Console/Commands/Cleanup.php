<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('cleanup')]
#[Description('Full cleanup app, including cleanup-appeals and cleanup-trashed-posts')]
class Cleanup extends Command
{
    public function handle()
    {
        $this->info('Starting cleanup...');

        $this->call('cleanup:appeals');
        $this->call('cleanup:trashed-posts');

        $this->info('Cleanup finished!');
    }
}
