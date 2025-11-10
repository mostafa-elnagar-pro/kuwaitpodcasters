<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\FileService;
use App\Models\PodcasterDetails;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show($id)
    {
        try {
            $user = User::withFollows()
                ->with(['podcasterDetails.category', 'channel'])
                ->findOrFail($id);

            return responseWithData(
                new UserResource($user)
            );
        } catch (\Throwable $e) {
            return ExceptionHandler::api($e);
        }
    }
    /**end of show */


    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        try {
            DB::beginTransaction();

            if (isset($data['profile_img'])) {
                $data['profile_img'] = FileService::uploadImage($data['profile_img'], 'profile', $user->profile_img);
            }

            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            $user->update($data);

            if ($user->type === 'podcaster') {
                $attributes = (new PodcasterDetails())->getFillable();
                $filteredData = collect($data)->only($attributes)->toArray();

                $user->podcasterDetails()->update($filteredData);
            }

            DB::commit();

            return responseWithData(
                new UserResource($user)
            );
        } catch (\Throwable $e) {
            rollbackUploadedFile($request->profile_img);
            DB::rollBack();
            return ExceptionHandler::api($e);
        }
    }
    /** end of update */
}
