<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractBeetwenRequest;
use App\Http\Requests\ContractByCompanyRequest;
use App\Http\Requests\ContractByDayReportRequest;
use App\Http\Requests\ContractByMonthReportRequest;
use App\Http\Requests\ContractByNumberRequest;
use App\Http\Requests\ContractByPhoneRequest;
use App\Http\Requests\ContractByYearReportRequest;
use App\Http\Requests\ContractCalcRequest;
use App\Http\Requests\ContractOldRequest;
use App\Http\Requests\ContractStoreRequest;
use App\Http\Requests\GetContractByYearAndCompany;
use App\Http\Requests\GetContractByYearAndCompanyRequest;
use App\Http\Requests\TestContractRequest;
use App\Models\Debet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ContractController extends BaseController
{
//findByClient_PhoneContainingAndWorker_Company_IdAndClient_Company_IdAndWorker_Id
    public function test()
    {
//        $contr = Contract::join('clients','clients.phone','=','contracts.client_id')->join('users','contracts.user_id', '=', 'users.id')->join('companies','users.company_id', '=', 'companies.id')->where([
//            ['clients.phone','4748061'],
//            ['companies.id',2],
//            ['contracts.active',true],
//        ])->get();
//        $cons = Contract::join('users','contracts.user_id', '=', 'users.id')->join('companies','users.company_id', '=', 'companies.id')->join('clients','clients.company_id','=','contracts.client_id')->where([
//            ['companies.id',2],
//            ['contracts.active',true],
//        ])->get();
//        dd("123321");
//        $c = Contract::where('user_id', 1)->
//        join('clients','clients.id','=','contracts.user_id')->
//            join('users', 'users.id', '=', 'contracts.user_id')->
//            where([
//                ['clients.phone', 'LIKE', '%6%'],
//                ['clients.company_id', '=', 1],
//                ['users.company_id', '=', 1],
////                ['users.id', '=', 1],
//        ])->get();
//        $list = [];
//        for ($x = 0; $x < $c->count(); $x++) {
//            $list[$x] = $c[$x]->product_name;
//        }
//
////        $c = Contract::where('client_id',1)->where('product_id',1)->join('users', 'contracts.user_id','=','users.id')->where('users.company_id',1)->get();
//
//        dd($list);

//        $savedDebet = Debet::create([
//            'month_name'=>"yanvar",
//            'summa'=>63000,
//            'contract_id'=>1,
////            'desc'=>"haqqinda",
//        ]);
//        $currentTime = Carbon::now()->monthName;
//        dd($currentTime);
//        $day = $savedDebet->created_at->day;
//        dd($day);
//        $currentTime = Carbon::create("")

//        return $testContractRequest->phone . " " . $testContractRequest->id;

        return Carbon::create(2024,1)->daysInMonth;
    }

    public function index()
    {
        $contracts = $this->contractService->getAll();
        return $this->response($contracts);
    }

    public function store(ContractStoreRequest $request)
    {
        $contract = $this->contractService->save($request);
        return $this->response($contract);
    }

    public function show($id)
    {
        $contract = $this->contractService->getOne($id);
        return $this->response($contract);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $contract = $this->contractService->destroy($id);
        return $this->response($contract);
    }

    public function byNumber(ContractByNumberRequest $request)
    {
        $contract = $this->contractService->byNumber($request->number);
        return $this->response($contract);
    }

    public function calc(ContractCalcRequest $request)
    {
        $calc = $this->contractService->calc($request);
        return $this->response($calc);
    }

    public function findByClientPhone(ContractByPhoneRequest $request)
    {
        $contract = $this->contractService->findByClientPhone($request);
        return $this->response($contract);
    }

    public function getMyContract()
    {
        $contracts = $this->contractService->getMyContract();
        return $this->response($contracts);
    }

    public function getAllContractByNoPayed()
    {
        $contracts = $this->contractService->getAllContractByNoPayed();
        return $this->response($contracts);
    }

    public function getAllContractByPayed()
    {
        $contracts = $this->contractService->getAllContractByPayed();
        return $this->response($contracts);
    }

    public function getAllContractByClientAndUser()
    {
        $contracts = $this->contractService->getAllContractByClientAndUser();
        return $this->response($contracts);
    }

    public function getContractByCompanyId(ContractByCompanyRequest $request)
    {
        $contracts = $this->contractService->getContractByCompanyId($request->id);
        return $this->response($contracts);
    }

    public function getAllContractByUserId(ContractByCompanyRequest $request)
    {
        $contracts = $this->contractService->getAllContractByUserId($request->id);
        return $this->response($contracts);
    }

    public function addContractOld(ContractOldRequest $request)
    {
        $oldContract = $this->contractService->addContractOld($request);
        return $this->response($oldContract);
    }

    public function getContractReportDayByCompany()
    {
        $reports = $this->contractService->getContractReportDayByCompany();
        return $this->response($reports);
    }

    public function getMyAllContractToNow()
    {
        $contracts = $this->contractService->getMyAllContractToNow();
        return $this->response($contracts);
    }

    public function getMyAllContractBeetwen(ContractBeetwenRequest $request)
    {
        $contracts = $this->contractService->getMyAllContractBeetwen($request->start, $request->end);
        return $this->response($contracts);
    }

    public function getContractReportYearByCompany(GetContractByYearAndCompanyRequest $request)
    {
        $contracts = $this->contractService->getContractReportYearByCompany($request->yearNumber);
        return $this->response($contracts);
    }

    public function getMyContractReportDay(ContractByDayReportRequest $request)
    {
        $contracts = $this->contractService->getMyContractReportDay($request->date);
        return $this->response($contracts);
    }

    public function getMyContractReportYear(ContractByYearReportRequest $request)
    {
        $contracts = $this->contractService->getMyContractReportYear($request->yearNumber);
        return $this->response($contracts);
    }

    public function getMyContractReportMonth(ContractByMonthReportRequest $request)
    {
        $contracts = $this->contractService->getMyContractReportMonth($request->monthNumber, $request->yearNumber);
        return $this->response($contracts);
    }


}
