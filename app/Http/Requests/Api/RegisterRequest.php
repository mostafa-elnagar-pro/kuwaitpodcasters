<?php

namespace App\Http\Requests\Api;

use App\Rules\ValidPhoneNumberRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:user,podcaster'],
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'unique:users,email'],
            'country_id' => ['required'],
            'phone' => ['required', 'unique:users,phone', new ValidPhoneNumberRule($this->country_id)],
            'password' => ['required', 'string', 'min:8'],
            'category_id' => ['required_if:type,podcaster', 'exists:categories,id'],
            'bio' => ['nullable', 'max:250'],
        ];
    }


    protected function failedValidation(Validator $v)
    {
        if ($this->wantsJson()) {
            throw new HttpResponseException(errorResponse($v->errors()->first()));
        }
    }
}
