<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SeasonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ? $this->onUpdate() : $this->onStore();
    }



    public function onStore(): array
    {
        return [
            'name' => ['required', 'max:50']
        ];
    }

    public function onUpdate(): array
    {
        return [
            'name' => ['required', 'max:50']
        ];
    }

    protected function failedValidation(Validator $v)
    {
        if ($this->wantsJson()) {
            throw new HttpResponseException(errorResponse($v->errors()->first()));
        }
    }
}
