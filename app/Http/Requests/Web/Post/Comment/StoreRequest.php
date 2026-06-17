<?php

namespace App\Http\Requests\Web\Post\Comment;

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
            'message' => 'required|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'This field is required.',
            'message.string' => 'Data must be of string type.',
            'message.max' => 'The message may not be greater than 1000 characters.',
        ];
    }
}
