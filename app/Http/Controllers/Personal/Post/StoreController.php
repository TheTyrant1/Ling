<?php

namespace App\Http\Controllers\Personal\Post;

use App\Http\Requests\Personal\Post\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $post = $this->storeService->store($data);
        return redirect()->route('personal.post.show', compact('post'));
    }
}
