<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\User\AccountVerified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('post.index', absolute: false));
        }

        $user = $request->user();

        Mail::to($user->email)->send(
            new AccountVerified($user, AccountVerified::verificationUrl($user))
        );

        return back()->with('status', 'verification-link-sent');
    }
}
