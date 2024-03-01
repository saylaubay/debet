<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Services\AuthService;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\ContractService;
use App\Services\DebetService;
use App\Services\ProductService;
use App\Services\RoleService;
use App\Services\RuleService;
use App\Services\UserService;
use Illuminate\Http\Request;

class RoleController extends BaseController
{

    public function __construct(ClientService $clientService, CompanyService $companyService, ContractService $contractService, DebetService $debetService, ProductService $productService, RoleService $roleService, RuleService $ruleService, UserService $userService, AuthService $authService)
    {
        $this->middleware('hasRole:SUPER_ADMIN');
        parent::__construct($clientService, $companyService, $contractService, $debetService, $productService, $roleService, $ruleService, $userService, $authService);
    }

    public function index()
    {
        $roles = $this->roleService->findAll();
        return $this->response($roles);
    }

    public function store(RoleStoreRequest $request)
    {
        $role = $this->roleService->save($request);
        return $this->response($role);
    }

    public function show($id)
    {
        $roles = $this->roleService->findById($id);
        return $this->response($roles);
    }

    public function update(RoleStoreRequest $request, $id)
    {
        $role = $this->roleService->update($request, $id);
        return $this->response($role);
    }

    public function destroy($id)
    {
        $role = $this->roleService->deleteById($id);
        return $this->response($role);
    }
}
