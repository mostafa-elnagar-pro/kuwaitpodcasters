<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KeywordRequest extends FormRequest
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
            'key' => ['required'],
            'type' => ['required', 'in:web,mobile'],
            'value.*' => ['required', 'string']
        ];
    }


    public function onUpdate(): array
    {
        return [
            'key' => ['required'],
            'type' => ['required', 'in:web,mobile'],
            'value.*' => ['required', 'string']
        ];
    }
}
