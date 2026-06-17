<?php

namespace App\Http\Requests\Personal\Comment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'This field is required.',
            'message.string' => 'Data must be of string type.',
        ];
    }
}
