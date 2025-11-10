<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class PodcasterController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $podcasters = User::withFollows()
                ->with('podcasterDetails.category', 'channel')
                ->where(['type' => 'podcaster', 'status' => 'active'])
                ->search($request->search)
                ->paginate($request->limit ?? 20);

            return responseWithPaginatedData(
                $podcasters,
                UserResource::class
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of __invoke */
}
