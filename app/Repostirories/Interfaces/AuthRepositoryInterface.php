<?php


namespace App\Repostirories\Interfaces;


interface AuthRepositoryInterface
{

    public function register();

    public function login($username, $password);

    public function logout();

}
