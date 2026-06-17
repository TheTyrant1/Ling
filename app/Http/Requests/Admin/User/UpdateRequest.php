<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_id' => 'required|in:1,2',
            'status_id' => 'required|in:1,2'
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => 'Role is required.',
            'status_id.required' => 'Status is required.'
        ];
    }
}
