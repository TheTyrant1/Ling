<?php

namespace App\Http\Requests\Personal\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:90',
            'content' => 'required|string',
            'preview_image' => 'required|file',
            'main_image' => 'required|file',
            'tags' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 90 characters.',

            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',

            'preview_image.required' => 'Please select a preview image.',
            'preview_image.file' => 'The preview image must be a valid file.',

            'main_image.required' => 'Please select a main image.',
            'main_image.file' => 'The main image must be a valid file.',

            'tags.string' => 'The tags must be a string.',
        ];
    }
}
