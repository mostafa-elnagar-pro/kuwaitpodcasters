<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidPhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class PodcasterRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'bio' => ['nullable', 'max:250'],
            'facebook' => ['nullable'],
            'youtube' => ['nullable'],
            'instagram' => ['nullable'],
            'twitter' => ['nullable'],
            'snapchat' => ['nullable'],
            'tiktok' => ['nullable'],
            'linkedin' => ['nullable'],
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->podcaster->id],
            'country_id' => ['required'],
            'phone' => ['required', new ValidPhoneNumberRule($this->country_id), 'unique:users,phone,' . $this->podcaster->id],
            'profile_img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'password' => ['nullable', 'min:8'],
            'status' => ['required', 'in:pending,active,inactive'],
            'category_id' => ['required', 'exists:categories,id'],
            'bio' => ['nullable', 'max:250'],
            'facebook' => ['nullable'],
            'youtube' => ['nullable'],
            'instagram' => ['nullable'],
            'twitter' => ['nullable'],
            'snapchat' => ['nullable'],
            'tiktok' => ['nullable'],
            'linkedin' => ['nullable'],
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
