<?php


namespace App\Repostirories;


use App\Models\ApiResponse;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Repostirories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function userTest()
    {
//        $res = new ApiResponse('test', true);
//        dd($res);
        // TODO: Implement userTest() method.
    }

    public function findAll()
    {
        return User::all();

    }

    public function findById($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function save($user)
    {
        return User::create([
            "first_name"=>$user->first_name,
            "last_name"=>$user->last_name,
            "username"=>$user->username,
            "phone"=>$user->phone,
            "email"=>$user->email,
            "company_id"=>$user->company_id,
            "role_id"=>$user->role_id,
            "balance"=>$user->balance,
            "password"=>Hash::make($user->password),
        ]);
    }

    public function deleteById($id)
    {
        $isHave = User::where('id', $id)->exists();
        if ($isHave){
            User::destroy($id);
            return true;
        }
        return false;
    }

    public function delete($user)
    {
        // TODO: Implement delete() method.
    }

    public function deleteAllById($ids)
    {
        // TODO: Implement deleteAllById() method.
    }

    public function deleteAll($users)
    {
        // TODO: Implement deleteAll() method.
    }

    public function findByUsername($username)
    {
        $user = User::where('username', $username)->get();
        return $user;
    }

    public function findByCompanyId($company_id)
    {
        return User::where('company_id', $company_id)->get();
    }

    public function findByCompany_IdAndRole_RoleName($company_id, $role_rolename)
    {
        $isHaveCID = Company::where('id', $company_id)->first();
        $isHaveRID = Role::where('id', $role_rolename)->first();
        if ($isHaveRID == null || $isHaveCID == null){
            return null;
        }
        $users = User::where([
            ['company_id', $company_id],
            ['role_id', $role_rolename],
        ])->get();
        return $users;
    }

    public function findByIdAndCompany_IdAndRole_idAndCompany_Active($id, $company_id, $role_id, $company_active)
    {
        $isHaveUID = User::where('id', $id)->first();
        $isHaveCID = Company::where('id', $company_id)->first();
        $isHaveRID = Role::where('id', $role_id)->first();
        $isHaveUAID = User::where('active', $company_active)->first();
        if ($isHaveRID == null || $isHaveCID == null || $isHaveUID == null || $isHaveUAID == null){
            return null;
        }
        $user = User::where([
            ['id', $id],
            ['company_id', $company_id],
            ['role_id', $role_id],
            ['active', $company_active],
        ])->first();
//        dd($user);
        $user->active= false;
        $user->save();
        return $user;
    }

    public function findByIdAndRole_RoleName($id, $role_name, $active)
    {
        $isHaveUID = User::where('id', $id)->exists();
        $isHaveRID = Role::where('name', $role_name)->exists();
        if (!$isHaveUID || !$isHaveRID){
            return null;
        }
        $rId = Role::where('name', $role_name)->first();
        $user = User::where([
            ['id', $id],
            ['role_id', $rId->id],
        ])->first();
        $user->active = $active;
        $user->save();
        return $user;
    }

    public function findByRole_RoleNameOrRole_RoleName($role_name, $role_name2)
    {
        // TODO: Implement findByRole_RoleNameOrRole_RoleName() method.
    }

    public function findByIdAndCompanyActive($id, $company_active)
    {
       return $user = User::where([
            ['id', $id],
        ])->first();

    }

    public function findByRole_RoleNameAndCompany_Id($role_name, $company_id)
    {
        $role = Role::where('name', $role_name)->first();
//        dd($role);
        $users = User::where([
            ['role_id', $role->id],
            ['company_id', $company_id],
        ])->get();
        return $users;
    }

    public function existsByUsername($username)
    {
        $user = User::where('username', $username)->exists();
//        dd($user);
        return $user;
    }

    public function findByIdAndCompany_IdAndRole_RoleNameAndCompany_Active($id, $company_id, $role_id, $active)
    {
        $user = User::where([
            ['id', $id],
            ['company_id', $company_id],
            ['role_id', $role_id],
            ['active', $active],
        ])->first();
        $user->active = true;
        $user->save();
        return $user;
    }
}
