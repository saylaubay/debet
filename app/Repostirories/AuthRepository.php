<?php


namespace App\Repostirories;


use App\Models\User;
use App\Repostirories\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{

    public function register()
    {
        // TODO: Implement register() method.
    }

    public function login($username, $password)
    {
        return User::where('username', $username)->first();
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }
}
