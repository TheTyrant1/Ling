<?php

namespace App\Http\Controllers\Personal\Appeal;

use App\Http\Requests\Personal\Appeal\StoreRequest;
use App\Models\Appeal;
use Illuminate\Support\Facades\RateLimiter;

class StoreController
{
    public  function __invoke(StoreRequest $request)
    {
        $appeal = Appeal::create(
            [
                'user_id' => auth()->id(),
                'type_id' => $request->type_id,
                'status_id' => 1,
                'user_message' => $request->user_message,
            ]
        );

        RateLimiter::hit('appeals:' . auth()->id(), 3600);

        return redirect()->route('personal.appeal.show', compact('appeal'));
    }
}
