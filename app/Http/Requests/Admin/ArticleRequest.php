<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return request()->isMethod('put') || request()->isMethod('patch') ? $this->onUpdate() : $this->onStore();
    }


    public function onStore(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'title.*'=> ['required'],
            'short_body.*'=> ['required'],
            'body.*'=> ['required'],
        ];
    }


    public function onUpdate(): array
    {
        return [
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'title.*'=> ['required'],
            'short_body.*'=> ['required'],
            'body.*'=> ['required'],
        ];
    }
}
