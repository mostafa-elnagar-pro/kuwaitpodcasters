<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExclusiveEpisodeRequest extends FormRequest
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
        $rules = [
            'user_id' => ['required', 'exists:users,id'],
            'channel_id' => ['required', 'exists:channels,id'],
            'season_id' => ['required', 'exists:seasons,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'media_type' => ['required', 'in:video,audio'],
            'media_source' => ['required', 'in:link,fileupload'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];

        if ($this->media_source === 'link') {
            $rules['link'] = ['required', 'string', 'url'];
        } elseif ($this->media_source === 'fileupload') {
            if ($this->media_type === 'video') {
                $rules['media_file'] = ['required', 'mimes:mp4,avi,mov,wmv,flv,webm', 'max:102400']; // 100MB max
            } else {
                $rules['media_file'] = ['required', 'mimes:mp3,wav,ogg,aac,m4a', 'max:51200']; // 50MB max
            }
        }

        return $rules;
    }


    public function onUpdate(): array
    {
        $rules = [
            'user_id' => ['required', 'exists:users,id'],
            'channel_id' => ['required', 'exists:channels,id'],
            'season_id' => ['required', 'exists:seasons,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'media_type' => ['required', 'in:video,audio'],
            'media_source' => ['required', 'in:link,fileupload'],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];

        if ($this->media_source === 'link') {
            $rules['link'] = ['required', 'string', 'url'];
        } elseif ($this->media_source === 'fileupload') {
            $rules['media_file'] = ['sometimes', 'nullable'];
            if ($this->hasFile('media_file')) {
                if ($this->media_type === 'video') {
                    $rules['media_file'] = array_merge($rules['media_file'], ['mimes:mp4,avi,mov,wmv,flv,webm', 'max:102400']);
                } else {
                    $rules['media_file'] = array_merge($rules['media_file'], ['mimes:mp3,wav,ogg,aac,m4a', 'max:51200']);
                }
            }
        }

        return $rules;
    }
}

