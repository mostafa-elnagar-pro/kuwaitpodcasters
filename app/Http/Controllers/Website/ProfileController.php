<?php

namespace App\Http\Controllers\Website;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Services\FileService;
use App\Models\PodcasterDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::withCount('favourites')->with('podcasterDetails.category')->findOrFail($id);

        return view('website.profile', [
            'user' => $user
        ]);
    }
    /**end of show */


    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $user = auth('web')->user();

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

            return back()
                ->with('success', __kw('profile_updated', 'تم تعديل الملف الشخصي بنجاح'));
        } catch (\Throwable $e) {
            rollbackUploadedFile($request->profile_img);
            DB::rollBack();
            return ExceptionHandler::panel($e);

        }

    }
    /**end of update */
}
