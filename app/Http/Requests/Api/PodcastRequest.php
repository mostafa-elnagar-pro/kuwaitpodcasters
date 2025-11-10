<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PodcastRequest extends FormRequest
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
        $isFirstOrLastChunk = $this->chunk_index === 1 || $this->chunk_index === $this->total_chunks;

        $rules = [
            'media_type' => ['required', 'in:video,audio'],
            'media_source' => ['required'] /** link | fileupload */
        ];

        if ($this->media_source === 'link') {
            $rules = $this->commonPodcastRules($rules);
            $rules['link'] = ['required', 'string'];
        } elseif ($this->media_source === 'fileupload') {
            $rules['total_chunks'] = ['required', 'numeric'];
            $rules['chunk_index'] = ['required', 'numeric'];
            $rules['chunk'] = ['required', 'file', 'max:2048'];
            $rules['upload_id'] = [Rule::requiredIf($this->chunk_index > 1)];

            if ($isFirstOrLastChunk) {
                $rules = $this->commonPodcastRules($rules);
            }
        } else {
            abort(400, __('messages.invalidMediaSource'));
        }

        return $rules;
    }

    public function onUpdate(): array
    {
        $isFirstOrLastChunk = $this->chunk_index === 1 || $this->chunk_index === $this->total_chunks;

        $rules = [
            'media_type' => ['sometimes', 'nullable', 'in:video,audio'],
            'media_source' => ['sometimes', 'nullable','in:fileupload,link'] /** link | fileupload */
        ];

        if ($this->media_source === 'link') {
            $rules = $this->commonPodcastRules($rules, true);
            $rules['link'] = ['required', 'string'];
        } elseif ($this->media_source === 'fileupload') {
            $rules['total_chunks'] = ['required', 'numeric'];
            $rules['chunk_index'] = ['required', 'numeric'];
            $rules['chunk'] = ['required', 'file', 'max:2048'];
            $rules['upload_id'] = [Rule::requiredIf($this->chunk_index > 1)];

            if ($isFirstOrLastChunk) {
                $rules = $this->commonPodcastRules($rules, true);
            }
        }
        else {
            $rules = $this->commonPodcastRules($rules, true);
        }

        return $rules;
    }


    protected function failedValidation(Validator $v)
    {
        if ($this->wantsJson()) {
            throw new HttpResponseException(errorResponse($v->errors()->first()));
        }
    }



    public function commonPodcastRules(array $rules, $isUpdating = false): array
    {
        $rules['name'] = ['required', 'string', 'max:50'];
        $rules['description'] = ['required', 'string', 'max:255'];
        $rules['duration'] = ['required', 'string'];

        $rules['image'] = !$isUpdating
            ? ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048']
            : ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'];

        return $rules;
    }
}
