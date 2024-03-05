<?php


namespace App\Services;


use App\Models\ApiResponse;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{

    public function register()
    {

    }

    public function login($request)
    {
        $user = $this->authRepository->login($request->username, $request->password);
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return new ApiResponse("Ruxsat joq!!!", false);
        }
//        return new ApiResponse("Token : ", true, $user->createToken($request->username)->plainTextToken);
        return new ApiResponse("Token : ", true, [
            "role"=>$user->role->name,
            "token"=>$user->createToken($request->username)->plainTextToken,
        ]);
    }

    public function logout()
    {

    }



}
