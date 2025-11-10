<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidPhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],
            'country_id' => ['required'],
            'phone' => ['required', new ValidPhoneNumberRule($this->country_id), 'unique:users,phone'],
            'profile_img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'password' => ['required', 'min:8'],
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->user->id],
            'country_id' => ['required'],
            'phone' => ['required', new ValidPhoneNumberRule($this->country_id), 'unique:users,phone,' . $this->user->id],
            'profile_img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'password' => ['nullable', 'min:8'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }


    protected function prepareForValidation(): void
    {
        [$country_code, $country_id] = explode('@', $this->country) + [null, null];

        $this->merge([
            'country_id' => $country_id,
            'phone' => $country_code . $this->phone
        ]);
    }

}
