<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookRequest extends FormRequest
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
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string'],
            'author' => ['required', 'array'],
            'author.*' => ['required', 'string'],
            'summary' => ['required', 'array'],
            'summary.*' => ['required', 'string'],
            'publication_year' => ['required', 'integer', 'min:1000', 'max:' . date('Y')],
            'publisher' => ['required', 'array'],
            'publisher.*' => ['required', 'string'],
        ];
    }


    public function onUpdate(): array
    {
        return $this->onStore();
    }


    protected function failedValidation(Validator $v)
    {
        if ($this->wantsJson()) {
            throw new HttpResponseException(errorResponse($v->errors()->first()));
        }
    }
}
