<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//Creates a task to clear posts that have been in the trash for 30 days and also clear appeals that were created 30 days ago.
Schedule::command('cleanup')->daily();

