<?php

namespace App\Notifications;

use App\Mail\User\AccountVerified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerifyWithQueueNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public function toMail($notifiable)
    {
        return new AccountVerified(
            $notifiable,
            AccountVerified::verificationUrl($notifiable)
        );
    }
}
