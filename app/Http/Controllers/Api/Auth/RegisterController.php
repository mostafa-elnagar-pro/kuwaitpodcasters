<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\SessionService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $user = User::create(array_merge($data, [
                'password' => bcrypt($data['password']),
                'status' => $data['type'] === 'podcaster' ? 'pending' : 'active'
            ]));

            if ($user->type === 'podcaster') {
                $user->podcasterDetails()->create([
                    'category_id' => $data['category_id'],
                    'bio' => $data['bio'],
                ]);
            }

            DB::commit();

            return successResponse();
        } catch (\Throwable $e) {
            DB::rollBack();
            return ExceptionHandler::api($e);
        }
    }
    /** end of register */
}
