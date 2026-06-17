<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Requests\Admin\Tag\StoreRequest;
use App\Models\Tag;

class StoreController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $tag = Tag::firstOrCreate(
            ['title' => $data['title']]
        );

        return redirect()->route('admin.tag.show', compact('tag'));
    }
}
