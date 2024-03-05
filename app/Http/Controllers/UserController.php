<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddBalanceRequest;
use App\Http\Requests\UserBlockAllRequest;
use App\Http\Requests\UserBlockRequest;
use App\Http\Requests\UserByUsernameRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\ApiResponse;
use App\Services\AuthService;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\ContractService;
use App\Services\DebetService;
use App\Services\ProductService;
use App\Services\RoleService;
use App\Services\RuleService;
use App\Services\UserService;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function Illuminate\Session\userId;
use function Ramsey\Uuid\Lazy\toString;

class UserController extends BaseController
{

    public function __construct(ClientService $clientService, CompanyService $companyService, ContractService $contractService, DebetService $debetService, ProductService $productService, RoleService $roleService, RuleService $ruleService, UserService $userService, AuthService $authService)
    {
        $this->middleware('hasRole:SUPER_ADMIN,ADMIN')->only('store');
        $this->middleware('hasRole:SUPER_ADMIN')->only('index');
        parent::__construct($clientService, $companyService, $contractService, $debetService, $productService, $roleService, $ruleService, $userService, $authService);
    }

    public function getUser()
    {
        $user = $this->userService->getUser();
        return $this->response($user);
    }

    public function getAllUsers()
    {
        Log::alert("SOraw keldi");
        $users = $this->userService->findAll();
        Log::alert("LIST = ".$users);
        return $this->response($users);
    }

    public function index()
    {
//        $this->middleware('hasRole:SUPER_ADMIN')->only($this->index());
        $users = $this->userService->findAll();
        return $this->response($users);
    }

    public function store(UserStoreRequest $request)
    {
        $user = $this->userService->save($request);
        return $this->response($user);
    }

    public function show($id)
    {
        $user = $this->userService->findById($id);
        return $this->response($user);
    }

    public function update(UserStoreRequest $request, $id)
    {
        $user = $this->userService->update($request, $id);
        return $this->response($user);
    }

    public function destroy($id)
    {
        $user = $this->userService->destroy($id);
        return $this->response($user);
    }

    public function findByUsername(UserByUsernameRequest $request)
    {
        $user = $this->userService->findByUsername($request->username);
        return $this->response($user);
    }

    public function getUsersMyCompany()
    {
        $user = $this->userService->getUsersMyCompany();
        return $this->response($user);
    }

    public function blockUser(UserBlockRequest $request)
    {
        $user = $this->userService->blockUser($request->id, auth()->user()->company_id, auth()->user()->role_id);
//        $user = $this->userService->blockUser($request->id, 1, 1);
        return $this->response($user);
    }

    public function blockAllUser($id, UserBlockAllRequest $request)
    {
        $user = $this->userService->blockAllUser($id, $request);
        return $this->response($user);
    }

    public function blockAdmin(UserBlockRequest $request)
    {
        $admin = $this->userService->blockAdmin($request->id);
        return $this->response($admin);
    }

    public function unBlockUser(UserBlockRequest $request)
    {
        $user = $this->userService->unBlockUser($request->id);
        return $this->response($user);
    }

    public function unBlockAdmin(UserBlockRequest $request)
    {
        $admin = $this->userService->unBlockAdmin($request->id);
        return $this->response($admin);
    }

    public function addBalance(UserAddBalanceRequest $request)
    {
        $balance = $this->userService->addBalance($request);
        return $this->response($balance);
    }

    public function getAllByCompanyId(UserBlockRequest $request)
    {
        $users = $this->userService->getAllByCompanyId($request->id);
        return $this->response($users);
    }

    public function getAllByMyCompany()
    {
        $myUsers = $this->userService->getAllByMyCompany(2);
        return $this->response($myUsers);
    }


}
