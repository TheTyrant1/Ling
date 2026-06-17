<?php

namespace App\Http\Requests\Admin\User;

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
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'email.required' => 'This field is required.',
            'email.string' => 'Data must be of string type.',
            'email.unique' => 'A profile with this email already exists.',
            'password.required' => 'This field is required.',
            'password.min' => 'Password must contain at least :min characters.',
            'password.string' => 'Data must be of string type.',
            'password.confirmed' => 'Passwords do not match.',
            'role_id.required' => 'This field is required.',
            'role_id.exists' => 'This role does not exist.',
        ];
    }
}
