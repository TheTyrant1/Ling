<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Requests\Admin\Tag\UpdateRequest;
use App\Models\Tag;

class UpdateController
{
    public function __invoke(UpdateRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        return redirect()->route('admin.tag.show', compact('tag'));
    }
}
