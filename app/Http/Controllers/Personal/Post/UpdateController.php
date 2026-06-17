<?php

namespace App\Http\Controllers\Personal\Post;

use App\Http\Requests\Personal\Post\UpdateRequest;
use App\Models\Post;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();

        $post = $this->updateService->update($data, $post);

        return redirect()->route('personal.post.show', compact('post'));
    }
}
