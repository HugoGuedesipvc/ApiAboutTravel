<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:90'],
            'email' => ['required', 'string', 'email', 'max:140', 'unique:users,email'],
            'username' => ['required', 'string', 'max:60', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'phone_number' => ['nullable', 'int', 'max:12'],
            'profile_picture' => ['nullable', 'file', "mimes:jpeg,png,jpg", 'max:2048'],
            'description' => ['nullable', 'string', 'max:800'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
