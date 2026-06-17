<?php

namespace App\Http\Controllers\Personal\History\Appeal;

use App\Http\Requests\Personal\Appeal\UpdateRequest;
use App\Models\Appeal;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Appeal $appeal)
    {
        $this->authorize('update', $appeal);
        $appeal->update($request->validated());

        return redirect()->route('personal.history.appeal.show', compact('appeal'));
    }
}
