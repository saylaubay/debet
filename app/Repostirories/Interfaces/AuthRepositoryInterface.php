<?php


namespace App\Repostirories\Interfaces;


interface AuthRepositoryInterface
{


    public function login($username, $password);

    public function logout();

}
