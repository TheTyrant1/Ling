<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountPasswordResetLink extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public $resetUrl;

    public $expireMinutes;

    public function __construct(User $user, string $resetUrl)
    {
        $this->user = $user;
        $this->resetUrl = $resetUrl;
        $this->expireMinutes = (int) config(
            'auth.passwords.'.config('auth.defaults.passwords').'.expire'
        );
    }

    public static function resetUrl(User $user, string $token): string
    {
        return url(route('password.reset', [
            'token' => $token,
            'email' => $user->getEmailForPasswordReset(),
        ], false));
    }

    public function build()
    {
        return $this->subject('Reset your password')
            ->view('personal::blade.mails.account-password-reset-link');
    }
}
