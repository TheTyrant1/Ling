<?php

namespace App\Http\Requests\Personal\Appeal;

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
            'type_id' => 'required|exists:appeal_types,id',
            'user_message' => 'required|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'type_id.required' => 'Type is required.',
            'type_id.exists' => 'This type does not exist.',
            'user_message.string' => 'User message must be a string.',
            'user_message.required' => 'Please write a message. We won’t be able to help you without it.',
            'user_message.max' => 'User message may not be greater than 500 characters.'
        ];
    }
}
