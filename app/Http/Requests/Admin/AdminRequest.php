<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:admins,email'],
            'password' => ['required', 'min:8'],
            'role' => ['required', 'exists:roles,id']
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(request()->user())],
            'password' => ['nullable', 'min:8'],
            'role' => ['required', 'exists:roles,id']
        ];
    }
}
