<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
            'user_id' => ['required'],
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function onUpdate(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }


    public function messages(): array
    {
        return [
            'user_id.required' => __('messages.selectPodcaster'),
        ];
    }
}
