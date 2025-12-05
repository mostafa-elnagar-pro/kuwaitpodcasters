<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return request()->isMethod('put') || request()->isMethod('patch') ? $this->onUpdate() : $this->onStore();
    }


    public function onStore(): array
    {
        return [
            'name.*' => ['required'],
            'author.*' => ['required'],
            'summary.*' => ['required'],
            'publication_year' => ['required', 'integer', 'min:1000', 'max:' . date('Y')],
            'publisher.*' => ['required'],
        ];
    }


    public function onUpdate(): array
    {
        return [
            'name.*' => ['required'],
            'author.*' => ['required'],
            'summary.*' => ['required'],
            'publication_year' => ['required', 'integer', 'min:1000', 'max:' . date('Y')],
            'publisher.*' => ['required'],
        ];
    }
}

