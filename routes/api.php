<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DebetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("/test", function (){
   return "TEST PAGE";
});

Route::group(['prefix' => 'auth'], function () {
    Route::post("login", [AuthController::class, 'login']);
    Route::post("logout", [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->group(function () {


    Route::group(['prefix' => 'companies'], function () {
        Route::get('hammesi', [CompanyController::class, 'hammesi']);
        Route::post('getAllCompany', [CompanyController::class, 'getAllCompany']);
        Route::put('blockCompany', [CompanyController::class, 'blockCompany']);
        Route::put('unBlockCompany', [CompanyController::class, 'unBlockCompany']);
    })->middleware('hasRole:SUPER_ADMIN');

    Route::group(['prefix' => 'debets'], function () {

        Route::middleware(['hasRole:SUPER_ADMIN,ADMIN,USER'])->group(function () {
            Route::post('setPay', [DebetController::class, 'setPay']);
            Route::get('getJournal', [DebetController::class, 'getJournal']);
            Route::put('updateDebet', [DebetController::class, 'updateDebet']);
            Route::get('getMyAllDebetToNow', [DebetController::class, 'getMyAllDebetToNow']);
            Route::post('getMyAllDebetBeetwen', [DebetController::class, 'getMyAllDebetBeetwen']);
            Route::post('getDebetByContractIdPayed', [DebetController::class, 'getDebetByContractIdPayed']);
            Route::post('getDebetByContractIdNoPayed', [DebetController::class, 'getDebetByContractIdNoPayed']);
        });

        Route::middleware(['hasRole:SUPER_ADMIN,ADMIN'])->group(function (){
            Route::get('getAllDebetByMyCompany', [DebetController::class, 'getAllDebetByMyCompany']);
            Route::get('getDebetReportDayByCompany', [DebetController::class, 'getDebetReportDayByCompany']);
        });

    });

    Route::group(['prefix' => 'contracts'], function () {
        Route::get('test', [ContractController::class, 'test']);

        Route::middleware(['hasRole:SUPER_ADMIN,ADMIN,USER'])->group(function (){
            Route::post('calc', [ContractController::class, 'calc']);
            Route::post('byNumber', [ContractController::class, 'byNumber']);
            Route::get('getMyContract', [ContractController::class, 'getMyContract']);
            Route::post('addContractOld', [ContractController::class, 'addContractOld']);
            Route::get('findByClientPhone', [ContractController::class, 'findByClientPhone']);
            Route::get('getAllContractByPayed', [ContractController::class, 'getAllContractByPayed']);
            Route::get('getMyAllContractToNow', [ContractController::class, 'getMyAllContractToNow']);
            Route::get('getMyContractReportDay', [ContractController::class, 'getMyContractReportDay']);
            Route::get('getMyContractReportYear', [ContractController::class, 'getMyContractReportYear']);
            Route::get('getAllContractByNoPayed', [ContractController::class, 'getAllContractByNoPayed']);
            Route::post('getMyAllContractBeetwen', [ContractController::class, 'getMyAllContractBeetwen']);
            Route::get('getMyContractReportMonth', [ContractController::class, 'getMyContractReportMonth']);
            Route::get('getAllContractByClientAndUser', [ContractController::class, 'getAllContractByClientAndUser']);

        });

        Route::middleware(['hasRole:SUPER_ADMIN,ADMIN'])->group(function (){
            Route::post('getAllContractByUserId', [ContractController::class, 'getAllContractByUserId']);
            Route::post('getContractByCompanyId', [ContractController::class, 'getContractByCompanyId']);
            Route::get('getContractReportDayByCompany', [ContractController::class, 'getContractReportDayByCompany']);
            Route::get('getContractReportYearByCompany', [ContractController::class, 'getContractReportYearByCompany']);
            Route::get('getContractReportMonthByCompany', [ContractController::class, 'getContractReportMonthByCompany']);
        });


    });

    Route::group(['prefix' => 'users'], function () {

        Route::middleware(['hasRole:SUPER_ADMIN,ADMIN,USER'])->group(function (){
            Route::get('getAllUsers', [UserController::class, 'getAllUsers'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
            Route::get('getUser', [UserController::class, 'getUser'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
            Route::get('findByUsername', [UserController::class, 'findByUsername'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        });

        Route::middleware(['hasRole:SUPER_ADMIN,ADMIN'])->group(function (){
            Route::put('blockUser', [UserController::class, 'blockUser']);
            Route::put('blockAdmin', [UserController::class, 'blockAdmin']);
            Route::put('addBalance', [UserController::class, 'addBalance']);
            Route::put('unBlockUser', [UserController::class, 'unBlockUser']);
            Route::put('unBlockAdmin', [UserController::class, 'unBlockAdmin']);
            Route::put('blockAllUser/{id}', [UserController::class, 'blockAllUser']);
            Route::get('getUsersMyCompany', [UserController::class, 'getUsersMyCompany']);
            Route::get('getAllByCompanyId', [UserController::class, 'getAllByCompanyId']);
            Route::get('getAllByMyCompany', [UserController::class, 'getAllByMyCompany']);
        });


    });

    Route::group(['prefix' => 'clients'], function () {
        Route::post('add', [ClientController::class, 'add'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getAllMyClient', [ClientController::class, 'getAllMyClient'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getClientsByUserId', [ClientController::class, 'getClientsByUserId'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
    });

    Route::apiResources([
        'users' => UserController::class,
        'rules' => RuleController::class,
        'roles' => RoleController::class,
        'debets' => DebetController::class,
        'clients' => ClientController::class,
        'products' => ProductController::class,
        'companies' => CompanyController::class,
        'contracts'=> ContractController::class,
    ]);




});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    dd(auth()->user()->created_at->year);
    return $request->user();
});




