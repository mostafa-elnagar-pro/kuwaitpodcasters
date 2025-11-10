<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ? $this->onUpdate() : $this->onStore();
    }



    protected function onStore(): array
    {
        return [
            'name.*' => ['required', 'string', 'max:40'],
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'is_active'=> ['required', 'in:0,1'],
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'name.*' => ['required', 'string', 'max:40'],
            'image' => ['sometimes', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'is_active'=> ['required', 'in:0,1'],
        ];
    }

}
