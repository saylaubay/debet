<?php

namespace App\Http\Controllers;

use App\Models\ApiResponse;
use App\Repostirories\Interfaces\ClientRepositoryInterface;
use App\Repostirories\Interfaces\CompanyRepositoryInterface;
use App\Repostirories\Interfaces\ContractRepositoryInterface;
use App\Repostirories\Interfaces\DebetRepositoryInterface;
use App\Repostirories\Interfaces\ProductRepositoryInterface;
use App\Repostirories\Interfaces\RoleRepositoryInterface;
use App\Repostirories\Interfaces\RuleRepositoryInterface;
use App\Repostirories\Interfaces\UserRepositoryInterface;
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
use Illuminate\Routing\Controller;
use PhpParser\Node\Expr\Cast\Bool_;

class BaseController extends Controller
{
    public $clientService;
    public $companyService;
    public $contractService;
    public $debetService;
    public $productService;
    public $roleService;
    public $ruleService;
    public $userService;
    public $authService;

    public function __construct(ClientService $clientService,
        CompanyService $companyService,
        ContractService $contractService,
        DebetService $debetService,
        ProductService $productService,
        RoleService $roleService,
        RuleService $ruleService,
        UserService $userService,
        AuthService $authService
    )
    {
        $this->clientService = $clientService;
        $this->companyService = $companyService;
        $this->contractService = $contractService;
        $this->debetService = $debetService;
        $this->productService = $productService;
        $this->roleService = $roleService;
        $this->ruleService = $ruleService;
        $this->userService = $userService;
        $this->authService = $authService;

    }
//    public function __construct()
//    {
//        $this->clientService = app(ClientService::class);
//        $this->companyService = app(CompanyService::class);
//        $this->contractService = app(ContractService::class);
//        $this->debetService = app(DebetService::class);
//        $this->productService = app(ProductService::class);
//        $this->roleService = app(RoleService::class);
//        $this->ruleService = app(RuleService::class);
//        $this->userService = app(UserService::class);
//        $this->authService = app(AuthService::class);
//
//    }


    public function oop()
    {
        return "5555";
    }

    public function response(ApiResponse $data)
    {
        return response()->json([
            'success' => $data->getSuccess(),
            'message' => $data->getMessage(),
            'data'=> $data->getData(),
        ], $data->getSuccess() ? 200 : 409);
    }



}
