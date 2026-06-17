<?php

namespace App\Http\Requests\Admin\Comment;

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
            'status_id' => 'required|in:1,2'
        ];
    }

    public function messages()
    {
        return [
            'status_id.required' => 'Status is required.',
        ];
    }
}
