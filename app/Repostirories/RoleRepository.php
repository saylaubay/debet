<?php


namespace App\Repostirories;


use App\Models\Role;
use App\Repostirories\Interfaces\RoleRepositoryInterface;

//use App\Repositories\Interfaces\RoleRepositoryInterface;

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

    public function existByName($name)
    {
        return Role::where('name', $name)->exists();
    }
}
