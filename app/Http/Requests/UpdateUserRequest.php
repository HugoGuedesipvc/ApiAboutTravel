<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    private $userId;

    public function __construct()
    {
        parent::__construct();
        $this->userId = Auth::id();
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:2'],
            'email' => ['nullable', 'string', 'email', 'max:140', 'unique:users,email,' . $this->userId],
            'username' => ['nullable', 'string', 'max:60', 'unique:users,username,' . $this->userId],
            'password' => ['nullable', 'string', 'min:6'],
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
