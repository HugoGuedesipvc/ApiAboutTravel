<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'local_type_id' => ['required', 'exists:local_types,id'],
            'label' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'files' => ['nullable', 'file', "mimes:jpeg,png,jpg", 'max:2048']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
