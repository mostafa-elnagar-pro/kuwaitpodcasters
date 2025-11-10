<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChannelRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function onUpdate(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }


    protected function failedValidation(Validator $v)
    {
        if ($this->wantsJson()) {
            throw new HttpResponseException(errorResponse($v->errors()->first()));
        }
    }
}
