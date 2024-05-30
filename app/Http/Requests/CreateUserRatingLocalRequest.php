<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRantingLocalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'local_id' => ['required', 'exists:locals,id'],
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
