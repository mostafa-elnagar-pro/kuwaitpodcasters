<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ExceptionHandler;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Http\Services\FileService;
use App\Models\Setting;
use Illuminate\Http\Request;


class SettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:settings-read', only: ['show']),
            new Middleware(['permission:settings-update'], only: ['updateSingle', 'updateTextRecords']),
        ];
    }
    /**end of middleware */


    public function show(Request $request)
    {
        $type = $request->type;

        return view("dashboard.pages.settings.{$type}s", [
            'settings' => Setting::where('type', $type)->get()
        ]);
    }
    /**end of index */


    public function updateSingle(SettingRequest $request, Setting $setting)
    {
        try {
            $data = $request->validated();

            if (in_array($data['type'], ['image', 'audio', 'video']) && isset($data['file'])) {
                if ($data['type'] === 'image') {
                    $data['value'] = FileService::uploadImage($data['file'], 'settings');

                } else {
                    $data['value'] = FileService::uploadVideoOrAudio(file: $data['file'], folder: 'settings', named: false);
                }
            }

            $setting->update($data);

            forgetCachedSettings();

            return back()
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of update */


    public function updateTextRecords(Request $request)
    {
        try {
            $list = array_map(fn($setting) => [
                'type' => 'text',
                'key' => array_keys($setting)[0],
                'value' => array_values($setting)[0]
            ], $request->settings);

            Setting::upsert($list, ['key'], ['value']);

            forgetCachedSettings();

            return to_route('admin.settings.index', ['type' => 'text'])
                ->with('success', __('messages.successUpdate'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedUpdate'));
        }
    }
    /**end of updateGroupedTexts */


    public function destroy(Request $request, Setting $setting)
    {
        try {
            if (in_array($request->type, ['image', 'video', 'audio'])) {
                FileService::unlink($setting->value);
            }

            $setting->update(['value' => null, 'trans_value' => null, 'none' => null]);

            forgetCachedSettings();

            return back()
                ->with('success', __('messages.successDelete'));
        } catch (\Throwable $e) {
            return ExceptionHandler::panel($e, __('messages.failedDelete'));
        }
    }
}
