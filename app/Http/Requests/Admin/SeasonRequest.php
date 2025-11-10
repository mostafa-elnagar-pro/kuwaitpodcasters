<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SeasonRequest extends FormRequest
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
            'channel_id' => ['required'],
            'name' => ['required', 'string', 'max:50'],
        ];
    }

    public function onUpdate(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
        ];
    }


    public function messages(): array
    {
        return [
            'channel_id.required' => __('messages.selectChannel'),
        ];
    }
}
