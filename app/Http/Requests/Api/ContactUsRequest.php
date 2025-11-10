<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:50'],
            'phone' => ['required'],
            'email' => ['required'],
            'message' => ['required', 'max:255'],
        ];
    }


    protected function failedValidation(Validator $v)
    {
        if ($this->wantsJson()) {
            throw new HttpResponseException(errorResponse($v->errors()->first()));
        }
    }
}
