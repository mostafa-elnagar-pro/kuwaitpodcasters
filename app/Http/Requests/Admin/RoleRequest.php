<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => ['required', 'unique:roles,name'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'name' => ['required'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ];
    }
}
