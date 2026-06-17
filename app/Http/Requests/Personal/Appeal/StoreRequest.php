<?php

namespace App\Http\Requests\Personal\Appeal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the profile is authorized to make this request.
     */
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

    public function after(): array
    {
        return [
            function ($validator) {
                $key = 'appeals:' . auth()->id();

                if (RateLimiter::tooManyAttempts($key, 3)) {
                    throw ValidationException::withMessages([
                        'user_message' => 'You can only create 3 appeals per hour.'
                    ]);
                }
            }
        ];
    }

    public function messages()
    {
        return [
            'type_id.required' => 'Type is required.',
            'type_id.exists' => 'This type does not exist.',
            'user_message.string' => 'Message must be a string.',
            'user_message.required' => 'Please write a message. We won’t be able to help you without it.',
            'user_message.max' => 'Message may not be greater than 150 characters.'
        ];
    }
}
