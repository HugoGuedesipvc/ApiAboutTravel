<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserSharedTripRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'trip_id' => ['required', 'exists:trips,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
