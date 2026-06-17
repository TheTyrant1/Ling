<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class StoreService
{
    public function store($data)
    {
        try {
            DB::beginTransaction();

            $tags = $data['tags'] ?? null;
            unset($data['tags']);

            if (isset($data['content'])) {
                $data['content'] = Purifier::clean($data['content']);
            }

            $data['user_id'] = auth()->id();

            if (isset($data['preview_image'])) {
                $data['preview_image'] = Storage::disk('public')
                    ->put('main/images/posts', $data['preview_image']);
            }

            if (isset($data['main_image'])) {
                $data['main_image'] = Storage::disk('public')
                    ->put('main/images/posts', $data['main_image']);
            }

            $post = Post::create($data);

            $tagIds = [];

            if (!empty($tags)) {
                if (is_string($tags)) {
                    $tags = explode(',', $tags);
                }

                foreach ($tags as $tag) {
                    $tag = ltrim(trim($tag), '#');

                    if (!$tag) continue;

                    $tagModel = Tag::firstOrCreate([
                        'title' => $tag
                    ]);

                    $tagIds[] = $tagModel->id;
                }
            }

            $post->tags()->sync($tagIds);

            DB::commit();

            return $post;

        } catch (Exception $exception) {
            DB::rollBack();
            abort(500);
        }
    }
}
