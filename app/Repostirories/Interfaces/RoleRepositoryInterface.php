<?php


namespace App\Repostirories\Interfaces;
//namespace App\Repositories\Interfaces;


interface RoleRepositoryInterface
{

    public function existByName($name);

    public function findAll();

    public function findById($id);

    public function save($role);

    public function deleteById($id);

}
