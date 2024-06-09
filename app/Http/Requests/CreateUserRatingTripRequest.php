<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRatingTripRequest extends FormRequest
{
    public function rules(): array
    {
        return [
          
            'user_id' => ['required', 'exists:users,id'],
            'trip_id' => ['required', 'exists:trips,id'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
