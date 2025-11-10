<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->onStore();
    }


    protected function onStore(): array
    {
        return [
            'group' => ['required'],
            'options' => ['required', 'array', 'min:1'],
            'options.*' => ['string', 'in:create,read,update,delete'],
        ];
    }

}
