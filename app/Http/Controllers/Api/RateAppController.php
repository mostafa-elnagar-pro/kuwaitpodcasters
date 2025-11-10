<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RateAppRequest;
use App\Http\Resources\AppRateResource;
use App\Models\AppRate;

class RateAppController extends Controller
{
    public function store(RateAppRequest $request)
    {
        try {
            $data = $request->validated();

            $data['user_id'] = auth()->id();

            AppRate::updateOrCreate(
                ['user_id' => $data['user_id']],
                $data
            );

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of store */


    public function show()
    {
        try {
            $rate = auth()->user()->appRate ?? null;
            return responseWithData($rate ? new AppRateResource($rate) : null);
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of show */


    public function destroy()
    {
        try {
            auth()->user()->appRate()->delete();

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of destroy */
}
