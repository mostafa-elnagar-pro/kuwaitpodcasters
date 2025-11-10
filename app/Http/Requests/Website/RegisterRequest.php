<?php

namespace App\Http\Requests\Website;

use App\Rules\ValidPhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // type => 'in:user,podcaster'

        return [
            'type' => ['required', 'in:user'],
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'unique:users,email'],
            'country_id' => ['required'],
            'phone' => ['required', 'unique:users,phone', new ValidPhoneNumberRule($this->country_id)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'category_id' => ['required_if:type,podcaster', 'exists:categories,id'],
            // 'bio' => ['nullable', 'max:250'],
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



    public function messages()
    {
        return [
            'category_id.required_if' => __('validation.required_if', [
                'attribute' => __('validation.attributes.category_id'),
                'value' => __('label.podcaster'),
            ]),
        ];
    }


}
