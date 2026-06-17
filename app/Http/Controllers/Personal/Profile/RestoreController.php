<?php

namespace App\Http\Controllers\Personal\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RestoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = $request->query('id');

        if (!$userId) {
            abort(404, 'User ID missing.');
        }

        $user = User::withTrashed()->findOrFail($userId);

        $user->restore();

        return redirect('/login')->with('success', 'Account restored. You can login now.');
    }
}
