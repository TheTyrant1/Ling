<?php

namespace App\Http\Controllers\Personal\Profile;

use App\Http\Controllers\Controller;
use App\Mail\User\AccountDeleted;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class DeleteController extends Controller
{
    public function __invoke(Request $request, User $user)
    {
        $restoreUrl = URL::temporarySignedRoute(
            'personal.profile.restore',
            now()->addDays(7),
            ['id' => $user->id]
        );

        Mail::to($user->email)->send(new AccountDeleted($user->name, $restoreUrl));

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account deactivated. Check your email.');
    }
}
