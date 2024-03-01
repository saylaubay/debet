<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{

    public function register(RegisterRequest $request)
    {

    }



    public function login(LoginRequest $request)
    {
        $login = $this->authService->login($request);

//        $user = User::where('email', $request->email)->first();

//        if (! $user || ! Hash::check($request->password, $user->password)) {
//            return response([
//                "response"=>"Ruxsat joq"
//            ], 200);
//        }
        return $this->response($login);
//        return $this->response($login->createToken($login->first_name)->plainTextToken);
    }

    public function logout()
    {
        $user = auth('sanctum')->user();
        $user->tokens()->delete();

        return response(["Logout"], 200);
    }



}
