<?php


namespace App\Services;


use App\Models\ApiResponse;
use App\Repostirories\Interfaces\AuthRepositoryInterface;
use App\Repostirories\Interfaces\ClientRepositoryInterface;
use App\Repostirories\Interfaces\CompanyRepositoryInterface;
use App\Repostirories\Interfaces\ContractRepositoryInterface;
use App\Repostirories\Interfaces\DebetRepositoryInterface;
use App\Repostirories\Interfaces\ProductRepositoryInterface;
use App\Repostirories\Interfaces\RoleRepositoryInterface;
use App\Repostirories\Interfaces\RuleRepositoryInterface;
use App\Repostirories\Interfaces\UserRepositoryInterface;

class BaseService
{

    protected $clientRepository;
    protected $companyRepository;
    protected $contractRepository;
    protected $debetRepository;
    protected $productRepository;
    protected $roleRepository;
    protected $ruleRepository;
    protected $userRepository;
    protected $authRepository;

//    public function __construct(ClientRepositoryInterface $clientRepository,
//                                CompanyRepositoryInterface $companyRepository,
//                                ContractRepositoryInterface $contractRepository,
//                                DebetRepositoryInterface $debetRepository,
//                                ProductRepositoryInterface $productRepository,
//                                RoleRepositoryInterface $roleRepository,
//                                RuleRepositoryInterface $ruleRepository,
//                                UserRepositoryInterface $userRepository,
//                                AuthRepositoryInterface $authRepository
//    )
//    {
//        $this->clientRepository = $clientRepository;
//        $this->companyRepository = $companyRepository;
//        $this->contractRepository = $contractRepository;
//        $this->debetRepository = $debetRepository;
//        $this->productRepository = $productRepository;
//        $this->roleRepository = $roleRepository;
//        $this->ruleRepository = $ruleRepository;
//        $this->userRepository = $userRepository;
//        $this->authRepository = $authRepository;
//
//    }

    public function __construct()
    {
        $this->clientRepository = app(ClientRepositoryInterface::class);
        $this->companyRepository = app(CompanyRepositoryInterface::class);
        $this->contractRepository = app(ContractRepositoryInterface::class);
        $this->debetRepository = app(DebetRepositoryInterface::class);
        $this->productRepository = app(ProductRepositoryInterface::class);
        $this->roleRepository = app(RoleRepositoryInterface::class);
        $this->ruleRepository = app(RuleRepositoryInterface::class);
        $this->userRepository = app(UserRepositoryInterface::class);
        $this->authRepository = app(AuthRepositoryInterface::class);

    }

    public function response(ApiResponse $data)
    {
        return response()->json([
            'data'=> $data->getData(),
            'success' => $data->getSuccess(),
            'message' => $data->getMessage(),
        ], $data->getSuccess() ? 200 : 409);
    }


}
