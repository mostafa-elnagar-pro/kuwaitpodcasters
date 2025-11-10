<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:text,trans_text,video,audio,image'],
            'key' => ['required', 'string', 'max:50', 'unique:settings,key,' . request()->setting->id],
            'value' => ['required_if:type,text', 'string', 'max:255'],
            'trans_value.*' => ['required_if:type,trans_text', 'string'],
            'file' => ['required_if:type,video,audio,image', 'file']
        ];
    }
}
