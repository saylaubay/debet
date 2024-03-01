<?php


namespace App\Services;


use App\Models\ApiResponse;

class RoleService extends BaseService
{

    public function findAll()
    {
        $roles = $this->roleRepository->findAll();
        return new ApiResponse("Role list : ", true, $roles);
    }

    public function findById($id)
    {
        $role = $this->roleRepository->findById($id);
        if ($role == null){
            return new ApiResponse("Bunday id li role tabilmadi!!!", false);
        }
        return new ApiResponse("Role : ", true, $role);
    }

    public function deleteById($id)
    {
        $role = $this->roleRepository->findById($id);
        if ($role == null){
            return new ApiResponse("Bunday id li role tabilmadi!!!", false);
        }
        $role = $this->roleRepository->deleteById($id);
        return new ApiResponse("Role o`shirildi!!! ", true);
    }

    public function save($role)
    {
        $isHave = $this->roleRepository->existByName($role->name);
        if ($isHave){
            return new ApiResponse("Bunday role bazada BAR!!!", false);
        }
        $role = $this->roleRepository->save($role);
        return new ApiResponse("Role saqlandi!!!", true, $role);
    }

    public function update($newRole, $id)
    {
        $role = $this->roleRepository->findById($id);
        if ($role == null){
            return new ApiResponse("Bunday role bazada JOQ!!!", false);
        }
        $role->name = $newRole->name;
        $role->desc = $newRole->desc;
        if (isset($newRole->active)){
            $role->active = $newRole->active;
        }
        $role->save();
        return new ApiResponse("Role Jan'alandi!!!", true, $role);
    }

}
