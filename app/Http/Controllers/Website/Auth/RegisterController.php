<?php

namespace App\Http\Controllers\Website\Auth;

use App\Helpers\ExceptionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegisterForm(Request $request)
    {
        return view('website.auth.register', [
            'type' => 'user' // $request->type
        ]);
    }
    /**end of showRegisterForm */


    public function register(RegisterRequest $request)
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

            return to_route('website.showLoginForm')->with('success', true);
        } catch (\Throwable $e) {
            DB::rollBack();
            return ExceptionHandler::panel($e);
        }
    }
}
