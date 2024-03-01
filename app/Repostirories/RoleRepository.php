<?php


namespace App\Repostirories;


use App\Models\Role;
use App\Repostirories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{

    public function findAll()
    {
        $roles = Role::all();
        return $roles;
    }

    public function findById($id)
    {
        $role = Role::find($id);
        return $role;
    }

    public function save($role)
    {
        return Role::create([
            "name"=>$role->name,
        ]);
    }

    public function deleteById($id)
    {
        return Role::destroy($id);
    }

    public function delete($role)
    {
        // TODO: Implement delete() method.
    }

    public function deleteAllById($ids)
    {
        // TODO: Implement deleteAllById() method.
    }

    public function deleteAll($roles)
    {
        // TODO: Implement deleteAll() method.
    }

    public function existByName($name)
    {
        return Role::where('name', $name)->exists();
    }
}