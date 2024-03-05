<?php


namespace App\Services;


use App\Http\Resources\UserResource;
use App\Models\ApiResponse;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use function Illuminate\Session\userId;

class UserService extends BaseService
{

    public function getUser()
    {
        $user = auth()->user();
        return new ApiResponse("User : ", true, new UserResource($user));
    }

    public function findAll()
    {
        $users = $this->userRepository->findAll();
        return new ApiResponse("User list : ", true, UserResource::collection($users));
    }

    public function findById($id)
    {
        $user = $this->userRepository->findById($id);
        if ($user == null){
            return new ApiResponse("Bunday id li User tabilmadi!!!", false);
        }
        return new ApiResponse("User : ", true, new UserResource($user));
    }

    public function save($request)
    {
        $isHave = $this->userRepository->existsByUsername($request->username);
        if (!$isHave){
            $user = $this->userRepository->save($request);
            return new ApiResponse("User saqlandi!!!", true, new UserResource($user));
        }
        return new ApiResponse("Bunday user bazada bar!!!", false);
    }

    public function update($request, $id)
    {
        $user = $this->userRepository->findById($id);
        if ($user == null){
            return new ApiResponse("Bunday id li user tabilmadi!!!", false);
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->company_id = $request->company_id;
        $user->role_id = $request->role_id;
        $user->balance = $request->balance;
        $user->password = $request->password;
        $user->save();
        return new ApiResponse("User updated!", true, new UserResource($user));
    }

    public function destroy($id)
    {
        $user = $this->userRepository->deleteById($id);
        if ($user){
            return new ApiResponse("User o`shirildi!!!", true);
        }
        return new ApiResponse("User tabilmadi!!!", false);
    }

    public function findByUsername($username)
    {
        $isHave = $this->userRepository->existsByUsername($username);
        if ($isHave){
            $user = $this->userRepository->findByUsername($username);
            return new ApiResponse("User : ", true, new UserResource($user));
        }
        return new ApiResponse("Bunda id li user tabilmadi!!!", false);
    }

    public function getUsersMyCompany()
    {
        $users = $this->userRepository->findByCompany_IdAndRole_RoleName(auth()->user()->company_id, auth()->user()->role_id);
//        $users = $this->userRepository->findByCompany_IdAndRole_RoleName(1, 4);
        if ($users == null){
            return new ApiResponse("Company yamasa role tabilmadi!!!", false);
        }
        return new ApiResponse("Users : ", true, UserResource::collection($users));
    }

    public function blockUser($id, $company_id, $role_id)
    {
        $users = $this->userRepository->findByIdAndCompany_IdAndRole_idAndCompany_Active($id, $company_id,$role_id,true);
        if ($users == null){
            return new ApiResponse("User id yamasa Company yamasa role id tabilmadi!!!", false);
        }
        return new ApiResponse("User bloklandi!!!", true, new UserResource($users));
    }

    public function blockAllUser($user_id, $request)
    {
        $isHave = User::where('id', $user_id)->exists();
//        dd($isHave);
        if (!$isHave){
            return new ApiResponse("Bunday user tabilmadi!", false);
        }
        $user = $this->userRepository->findById($user_id);
        $user->active = $request->active;
        $user->save();
        return new ApiResponse("User bloklandi!", true, new UserResource($user));
    }

    public function blockAdmin($id)
    {
        $user = $this->userRepository->findByIdAndRole_RoleName($id, "ADMIN", false);
        if ($user == null){
            return new ApiResponse("User id yamasa role id tabilmadi!!!", false);
        }
        return new ApiResponse("Admin bloklandi!!!", true, new UserResource($user));
    }

    public function unBlockUser($id)
    {
        $user = $this->userRepository->findById($id);
        $company = $this->companyRepository->findById($user->company_id);
        $role = $this->roleRepository->findById($user->role_id);
//        $user = User::where('id',$id)->first();
//        $company = Company::where('id',$user->company_id)->first();
//        $role = Role::where('id',$user->role_id)->first();
        if ($user == null || $company == null || $role == null){
            return new ApiResponse("User id yamasa company id yamasa role id tabilmadi!!!", false);
        }
        $user = $this->userRepository->findByIdAndCompany_IdAndRole_RoleNameAndCompany_Active($id, $company->id, $role->id, false);
        return new ApiResponse("User bloktan shag'arildi!!!", true, new UserResource($user));
    }

    public function unBlockAdmin($id)
    {
        $user = $this->userRepository->findByIdAndRole_RoleName($id, "ADMIN", true);
        if ($user == null){
            return new ApiResponse("Admin id yamasa role id tabilmadi!!!", false);
        }
        return new ApiResponse("Admin bloktan shig`arildi!!!", true, new UserResource($user));
    }

    public function addBalance($request)
    {
        $user = $this->userRepository->findById($request->worker_id);
        $company = $this->companyRepository->findById($user->company_id);
//        $user = User::where('id',$request->worker_id)->first();
//        $company = Company::where('id',$user->company_id)->first();
        if ($user == null || $company == null || $company->active == false){
            return new ApiResponse("Qa'te mag'liwmatlar kiritildi!!!", false);
        }
        $BUser = $this->userRepository->findByIdAndCompanyActive($user->id, true);
        $BUser->balance = $BUser->balance + $request->summa;
        $BUser->save();
        return new ApiResponse("Balance userg'a qosildi!!!", true, new UserResource($BUser));
    }

    public function getAllByCompanyId($id)
    {
        $user = $this->userRepository->findById($id);
//        $user = User::where('id', $id)->first();
        if ($user == null){
            return new ApiResponse("Bunday id li company tabilmadi!!!", false);
        }
        $users = $this->userRepository->findByCompanyId($id);
        return new ApiResponse("User list : ", true, UserResource::collection($users));
    }

    public function getAllByMyCompany($id)
    {
        $company = $this->companyRepository->findById($id);
        if ($company == null){
            return new ApiResponse("Bunday id li company tabilmadi!!!", false);
        }
        $users = $this->userRepository->findByRole_RoleNameAndCompany_Id("USER", $id);
        return new ApiResponse("User list : ", true, UserResource::collection($users));
    }

}
