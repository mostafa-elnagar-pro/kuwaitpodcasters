<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactUsRequest;
use App\Models\Feedback;

class ContactUsController extends Controller
{
    public function __invoke(ContactUsRequest $request)
    {
        try {
            $data = $request->validated();

            Feedback::create($data);

            return successResponse();
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
}
