<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:255'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'location' => ['nullable', 'string', 'max:255'],
            'initialDate' => ['required', 'date'],
            'endDate' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'file', "mimes:jpeg,png,jpg", 'max:2048'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'shared' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
