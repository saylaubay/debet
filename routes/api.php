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


Route::group(['prefix' => 'auth'], function () {
    Route::post("login", [AuthController::class, 'login']);
    Route::post("logout", [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->group(function () {


    Route::group(['prefix' => 'companies'], function () {
        Route::put('blockCompany', [CompanyController::class, 'blockCompany']);
        Route::put('unBlockCompany', [CompanyController::class, 'unBlockCompany']);
    })->middleware('hasRole:SUPER_ADMIN');

    Route::group(['prefix' => 'debets'], function () {
        Route::post('setPay', [DebetController::class, 'setPay'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getJournal', [DebetController::class, 'getJournal'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::put('updateDebet', [DebetController::class, 'updateDebet'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getMyAllDebetToNow', [DebetController::class, 'getMyAllDebetToNow'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::post('getMyAllDebetBeetwen', [DebetController::class, 'getMyAllDebetBeetwen'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getAllDebetByMyCompany', [DebetController::class, 'getAllDebetByMyCompany'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::post('getDebetByContractIdPayed', [DebetController::class, 'getDebetByContractIdPayed'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getDebetReportDayByCompany', [DebetController::class, 'getDebetReportDayByCompany'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::post('getDebetByContractIdNoPayed', [DebetController::class, 'getDebetByContractIdNoPayed'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
    });

    Route::group(['prefix' => 'contracts'], function () {
        Route::get('test', [ContractController::class, 'test']);
        Route::post('calc', [ContractController::class, 'calc'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::post('byNumber', [ContractController::class, 'byNumber'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getMyContract', [ContractController::class, 'getMyContract'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::post('addContractOld', [ContractController::class, 'addContractOld'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('findByClientPhone', [ContractController::class, 'findByClientPhone'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getAllContractByPayed', [ContractController::class, 'getAllContractByPayed'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getMyAllContractToNow', [ContractController::class, 'getMyAllContractToNow'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getMyContractReportDay', [ContractController::class, 'getMyContractReportDay'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::post('getAllContractByUserId', [ContractController::class, 'getAllContractByUserId'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::post('getContractByCompanyId', [ContractController::class, 'getContractByCompanyId'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::get('getMyContractReportYear', [ContractController::class, 'getMyContractReportYear'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getAllContractByNoPayed', [ContractController::class, 'getAllContractByNoPayed'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::post('getMyAllContractBeetwen', [ContractController::class, 'getMyAllContractBeetwen'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getMyContractReportMonth', [ContractController::class, 'getMyContractReportMonth'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getAllContractByClientAndUser', [ContractController::class, 'getAllContractByClientAndUser'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getContractReportDayByCompany', [ContractController::class, 'getContractReportDayByCompany'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::get('getContractReportYearByCompany', [ContractController::class, 'getContractReportYearByCompany'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::get('getContractReportMonthByCompany', [ContractController::class, 'getContractReportMonthByCompany'])->middleware('hasRole:SUPER_ADMIN,ADMIN');

    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('getUser', [UserController::class, 'getUser'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::put('blockUser', [UserController::class, 'blockUser'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::put('blockAdmin', [UserController::class, 'blockAdmin'])->middleware('hasRole:SUPER_ADMIN');
        Route::put('addBalance', [UserController::class, 'addBalance'])->middleware('hasRole:SUPER_ADMIN');
        Route::put('unBlockUser', [UserController::class, 'unBlockUser'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::put('unBlockAdmin', [UserController::class, 'unBlockAdmin'])->middleware('hasRole:SUPER_ADMIN');
        Route::get('findByUsername', [UserController::class, 'findByUsername'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::put('blockAllUser/{id}', [UserController::class, 'blockAllUser'])->middleware('hasRole:SUPER_ADMIN');
        Route::get('getUsersMyCompany', [UserController::class, 'getUsersMyCompany'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::get('getAllByCompanyId', [UserController::class, 'getAllByCompanyId'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
        Route::get('getAllByMyCompany', [UserController::class, 'getAllByMyCompany'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
    });

    Route::group(['prefix' => 'clients'], function () {
        Route::get('getAllMyClient', [ClientController::class, 'getAllMyClient'])->middleware('hasRole:SUPER_ADMIN,ADMIN,USER');
        Route::get('getClientsByUserId', [ClientController::class, 'getClientsByUserId'])->middleware('hasRole:SUPER_ADMIN,ADMIN');
    });

    Route::apiResources([
        'users' => UserController::class,//
        'roles' => RoleController::class,//
        'rules' => RuleController::class,
        'debets' => DebetController::class,//
        'clients' => ClientController::class,//
        'products' => ProductController::class,
        'companies' => CompanyController::class,//
        'contracts'=> ContractController::class,
    ]);




});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    dd(auth()->user()->created_at->year);
    return $request->user();
});




