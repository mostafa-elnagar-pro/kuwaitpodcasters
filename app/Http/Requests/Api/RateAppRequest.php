<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RateAppRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => ['required', 'numeric', 'min:1', 'max:5'],
            'message' => ['nullable', 'string', 'max:255']
        ];
    }
}
