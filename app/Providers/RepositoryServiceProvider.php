<?php

namespace App\Providers;

use App\Repostirories\AuthRepository;
use App\Repostirories\ClientRepository;
use App\Repostirories\CompanyRepository;
use App\Repostirories\ContractRepository;
use App\Repostirories\DebetRepository;
use App\Repostirories\Interfaces\AuthRepositoryInterface;
use App\Repostirories\Interfaces\ClientRepositoryInterface;
use App\Repostirories\Interfaces\CompanyRepositoryInterface;
use App\Repostirories\Interfaces\ContractRepositoryInterface;
use App\Repostirories\Interfaces\DebetRepositoryInterface;
use App\Repostirories\Interfaces\ProductRepositoryInterface;
use App\Repostirories\Interfaces\RoleRepositoryInterface;
use App\Repostirories\Interfaces\RuleRepositoryInterface;
use App\Repostirories\Interfaces\UserRepositoryInterface;
use App\Repostirories\ProductRepository;
use App\Repostirories\RoleRepository;
use App\Repostirories\RuleRepository;
use App\Repostirories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
        $this->app->bind(DebetRepositoryInterface::class, DebetRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(RuleRepositoryInterface::class, RuleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
