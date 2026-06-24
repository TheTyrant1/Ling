<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountDeleted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $userName;
    public $restoreUrl;

    public function __construct($userName, $restoreUrl)
    {
        $this->userName = $userName;
        $this->restoreUrl = $restoreUrl;
    }

    public function build()
    {
        return $this
            ->subject('Account deactivation')
            ->view('personal::blade.mails.account-deleted');
    }
}
