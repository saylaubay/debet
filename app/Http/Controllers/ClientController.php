<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientByIdRequest;
use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use App\Models\User;
use App\Services\AuthService;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\ContractService;
use App\Services\DebetService;
use App\Services\ProductService;
use App\Services\RoleService;
use App\Services\RuleService;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class ClientController extends BaseController
{

    public function __construct(ClientService $clientService, CompanyService $companyService, ContractService $contractService, DebetService $debetService, ProductService $productService, RoleService $roleService, RuleService $ruleService, UserService $userService, AuthService $authService)
    {
        $this->middleware('hasRole:SUPER_ADMIN,ADMIN')->only('getClientsByUserId');
        $this->middleware('hasRole:SUPER_ADMIN,ADMIN,USER')->only('store');
        $this->middleware('hasRole:SUPER_ADMIN,ADMIN,USER')->only('add');
        $this->middleware('hasRole:SUPER_ADMIN')->only('index');
        parent::__construct($clientService, $companyService, $contractService, $debetService, $productService, $roleService, $ruleService, $userService, $authService);
    }

    public function index()
    {
        $clients = $this->clientService->getAll();
        return $this->response($clients);
    }

    public function add(ClientStoreRequest $request)
    {
        $store = $this->clientService->addClient($request);
        return $this->response($store);
    }

   public function store(ClientStoreRequest $request)
    {
        $store = $this->clientService->addClient($request);
        return $this->response($store);
    }

    public function show($id)
    {
        $client = $this->clientService->findById($id);
        return $this->response($client);
    }

    public function update(ClientStoreRequest $request, $id)
    {
        $update = $this->clientService->update($id, $request);
        return $this->response($update);
    }

//    public function destroy($id)
//    {
//        $client = $this->clientService->destroy($id);
//        return $this->response($client);
//    }

    public function getAllMyClient()
    {
        $clients = $this->clientService->getAllMyClient(1);
        return $this->response($clients);
    }

    public function getClientsByUserId(ClientByIdRequest $request)
    {
        $clients = $this->clientService->getClientsByUserId($request->id);
        return $this->response($clients);
    }


    public function test()
    {
        return "OOP22222";
    }


}
