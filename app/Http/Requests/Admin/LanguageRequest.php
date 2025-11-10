<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        return request()->isMethod('put') || request()->isMethod('patch') ? $this->onUpdate() : $this->onStore();
    }


    // public function onStore()
    // {
    //     return [
    //         'name' => ['required', 'string', 'max:40', 'unique:languages,name'],
    //         'abbr' => ['required', 'unique:languages,abbr'],
    //         'direction' => ['required', 'in:ltr,rtl'],
    //         'is_active' => ['required', 'boolean'],
    //     ];
    // }

    public function onUpdate()
    {
        return [
            'name.*' => ['required', 'string', 'max:40', 'unique_translation:languages,name,' . $this->language->id],
            'is_active' => ['required', 'boolean'],
        ];
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => (bool) $this->active,
        ]);
    }
}
