<?php


namespace App\Repostirories\Interfaces;


interface RoleRepositoryInterface
{

    public function existByName($name);

    public function findAll();

    public function findById($id);

    public function save($role);

    public function deleteById($id);

    public function delete($role);

    public function deleteAllById($ids);

    public function deleteAll($roles);







}
