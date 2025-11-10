<?php

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;



if (!function_exists('formatLangLabel')) {
    function formatLangLabel($name, $abbr)
    {
        return __("label.$name") . ' (' . __("locale.{$abbr}") . ')';
    }
}


if (!function_exists('displayFlag')) {
    function displayFlag(string|null $flag = null)
    {
        $path = 'assets/admin/app-assets/fonts/flag-icon-css/flags/1x1';

        return !is_null($flag) ? url("$path/$flag.svg") : url("$path/zz.svg");
    }
}


if (!function_exists('displayFile')) {
    function displayFile(string|null $filePath = null, $default = null)
    {
        if (is_null($filePath)) {
            $default ??= 'logo.png';
            return url("/assets/images/$default");
        }

        return url($filePath);
    }
}


if (!function_exists('activePath')) {
    function activePath(array $routes)
    {
        return in_array(request()->path(), $routes) ? 'active' : '';
    }
}


if (!function_exists('formatDate')) {
    function formatDate($date = null, $relative = false)
    {
        if (is_null($date)) {
            return null;
        }

        $parsedDate = Carbon::parse($date);

        return $relative ? $parsedDate->diffForHumans() : $parsedDate->format('Y-m-d');
    }
}


if (!function_exists('authResponseWithData')) {
    function authResponseWithData($data, $cookie, $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            'status' => true,
            "message" => "success",
            "data" => $data
        ], $statusCode)->withCookie($cookie);
    }
}


if (!function_exists('responseWithData')) {
    function responseWithData($data)
    {
        return response()->json([
            'status' => true,
            "message" => "success",
            "data" => $data
        ]);
    }
}


if (!function_exists('responseWithPaginatedData')) {
    function responseWithPaginatedData($list, $resource)
    {
        $response = [
            'status' => true,
            'message' => 'success',
            'current_page' => $list->currentPage(),
            'last_page' => $list->lastPage(),
            'per_page' => $list->perPage(),
            'total' => $list->total(),
            'data' => $resource::collection($list->items()),
        ];

        return response()->json($response);
    }
}


if (!function_exists('successResponse')) {
    function successResponse($message = "success", $statusCode = Response::HTTP_OK)
    {
        return response()->json([
            "status" => true,
            "message" => $message,
        ], $statusCode);
    }
}


if (!function_exists('errorResponse')) {
    function errorResponse(string|null $message = null, int $statusCode = Response::HTTP_BAD_REQUEST)
    {
        $message = $message ?? __('messages.error');

        return response()->json([
            "status" => false,
            "message" => $message,
        ], $statusCode);
    }
}




if (!function_exists('rollbackUploadedFile')) {
    function rollbackUploadedFile(string|null $filePath)
    {
        if (isset($filePath)) {
            \App\Http\Services\FileService::unlink($filePath);
        }
        return;
    }
}

if (!function_exists('rollbackUploadedFiles')) {
    function rollbackUploadedFiles(array $files)
    {
        foreach ($files as $file) {
            if (isset($file)) {
                \App\Http\Services\FileService::unlink($file);
            }
        }
        return;
    }
}



if (!function_exists('forgetCachedSettings')) {
    function forgetCachedSettings()
    {
        foreach (\App\Http\Services\LangService::active()->pluck('abbr') as $lang) {
            Illuminate\Support\Facades\Cache::forget("web_settings_data_$lang");
            Illuminate\Support\Facades\Cache::forget("mobile_settings_data_$lang");
        }
    }
}


if (!function_exists('__kw')) {
    function __kw($keyword, $default = '')
    {
        $keywords = app('settings')['keywords'] ?? [];

        if (isset($keywords[$keyword]) && $keywords[$keyword]) {
            return $keywords[$keyword];
        }

        return $default;
    }
}