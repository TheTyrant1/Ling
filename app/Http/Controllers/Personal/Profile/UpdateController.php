<?php

namespace App\Http\Controllers\Personal\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personal\User\UpdateRequest;
use App\Mail\User\AccountUpdated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request)
    {
        $user = auth()->user();

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $request->file('profile_image')->store('main/images/profile_images', 'public');
            $user->save();
            return back()->with('success', 'Profile photo updated successfully!');
        }

        if ($request->filled('current_password') && $request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            Mail::to($user->email)->send(new AccountUpdated($user));

            return back()->with('success', 'Password updated successfully!');
        }

        if ($request->hasAny(['name', 'email'])) {
            $user->fill($request->only('name', 'email'))->save();
            Mail::to($user->email)->send(new AccountUpdated($user));

            return back()->with('success', 'Profile information updated!');
        }

        return back()->with('info', 'No changes detected.');
    }
}
