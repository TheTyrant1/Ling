<?php

namespace App\Http\Requests\Admin\Appeal;

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
            'admin_message' => 'nullable|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'admin_message.string' => 'Admin message must be a string.',
            'admin_message.max' => 'Admin message may not be greater than 500 characters.'
        ];
    }


}
