<?php

namespace App\Http\Controllers\Admin\Appeal;

use App\Http\Requests\Admin\Appeal\UpdateRequest;
use App\Models\Appeal;

class UpdateController
{
    public function __invoke(UpdateRequest $request, Appeal $appeal)
    {
        $appeal->update($request->validated());

        return redirect()->route('admin.appeal.show', compact('appeal'));
    }
}
