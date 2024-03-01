<?php


namespace App\Repostirories\Interfaces;


interface UserRepositoryInterface
{

    public function existsByUsername($username);

    public function userTest();

    public function findAll();

    public function findById($id);

    public function save($user);

    public function deleteById($id);

    public function delete($user);

    public function deleteAllById($ids);

    public function deleteAll($users);


    public function findByUsername($username);

    public function findByCompanyId($company_id);

    public function findByCompany_IdAndRole_RoleName($company_id, $role_rolename);

    public function findByIdAndCompany_IdAndRole_idAndCompany_Active($id, $company_id, $role_name, $company_active);

    public function findByIdAndRole_RoleName($id, $role_name, $active);

    public function findByRole_RoleNameOrRole_RoleName($role_name, $role_name2);

    public function findByIdAndCompanyActive($id, $company_active);

    public function findByRole_RoleNameAndCompany_Id($role_name, $company_id);

    public function findByIdAndCompany_IdAndRole_RoleNameAndCompany_Active($id, $company_id, $role_id, $active);


}
