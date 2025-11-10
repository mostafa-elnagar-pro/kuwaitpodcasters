<?php

namespace App\Http\Requests\Api;

use App\Rules\ValidPhoneNumberRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $user_id = auth()->id();

        $rules = [
            'source' => ['sometimes', 'in:web'],
            'profile_img' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'name' => ['sometimes', 'string', 'max:40'],
            'country_id' => [Rule::requiredIf(fn() => $this->phone), 'exclude_if:phone,'],
            'email' => ['sometimes', 'email', "unique:users,email,$user_id"],
            'phone' => ['sometimes', "unique:users,phone,$user_id", new ValidPhoneNumberRule($this->country_id), 'exclude_if:phone,'],
            'bio' => ['sometimes', 'nullable', 'string', 'max:250'],
            'facebook' => ['sometimes', 'nullable', 'string'],
            'youtube' => ['sometimes', 'nullable', 'string'],
            'instagram' => ['sometimes', 'nullable', 'string'],
            'twitter' => ['sometimes', 'nullable', 'string'],
            'snapchat' => ['sometimes', 'nullable', 'string'],
            'tiktok' => ['sometimes', 'nullable', 'string'],
        ];

        if ($this->source === 'web' && $this->password) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['password'] = ['sometimes', 'string', 'min:8', 'confirmed'];
        } else {
            $rules['password'] = ['sometimes', 'string', 'min:8'];
        }

        return $rules;
    }


    protected function prepareForValidation(): void
    {
        if ($this->source !== 'web') {
            return;
        }

        [$country_code, $country_id] = explode('@', $this->country) + [null, null];

        $this->merge([
            'country_id' => $country_id,
            'phone' => $country_code . $this->phone
        ]);
    }



    protected function failedValidation(Validator $v)
    {
        if ($this->wantsJson()) {
            throw new HttpResponseException(errorResponse($v->errors()->first()));
        }
    }
}
