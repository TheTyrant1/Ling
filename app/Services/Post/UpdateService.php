<?php

namespace App\Services\Post;

use App\Models\Tag;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class UpdateService
{
    public function update($data, $post)
    {
        try {
            DB::beginTransaction();

            $tags = $data['tags'] ?? null;
            unset($data['tags']);

            if (isset($data['content'])) {
                $data['content'] = Purifier::clean($data['content']);
            }

            $data['user_id'] = auth()->id();

            // preview image
            if (isset($data['preview_image']) && $data['preview_image'] instanceof UploadedFile) {

                $newPath = Storage::disk('public')->put('images/posts', $data['preview_image']);

                if ($post->preview_image && Storage::disk('public')->exists($post->preview_image)) {
                    Storage::disk('public')->delete($post->preview_image);
                }

                $data['preview_image'] = $newPath;
            } else {
                unset($data['preview_image']);
            }

            // main image
            if (isset($data['main_image']) && $data['main_image'] instanceof UploadedFile) {

                $newPath = Storage::disk('public')->put('images/posts', $data['main_image']);

                if ($post->main_image && Storage::disk('public')->exists($post->main_image)) {
                    Storage::disk('public')->delete($post->main_image);
                }

                $data['main_image'] = $newPath;
            } else {
                unset($data['main_image']);
            }

            $post->update($data);

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

        } catch (Exception $e) {
            DB::rollBack();
            abort(500);
        }
    }
}
