<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebetBeetwenRequest;
use App\Http\Requests\DebetByContractIdRequest;
use App\Http\Requests\DebetSetPayRequest;
use App\Http\Requests\DebetStoreRequest;
use App\Http\Requests\UpdateDebetRequest;
use App\Http\Resources\DebetResource;
use Illuminate\Http\Request;

class DebetController extends BaseController
{


    public function index()
    {
        $debets = $this->debetService->getAll();
        return $this->response($debets);
    }


    public function store(DebetStoreRequest $request)
    {
        $debet = $this->debetService->save($request);
        return $this->response($debet);
    }


    public function show($id)
    {
        $debet = $this->debetService->getOne($id);
        return $this->response($debet);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $debet = $this->debetService->destroy($id);
        return $this->response($debet);
    }

    public function setPay(DebetSetPayRequest $request)
    {
        $debet = $this->debetService->setPay($request);
        return $this->response($debet);
    }

    public function getAllDebetByMyCompany()
    {
        $debets = $this->debetService->getAllDebetByMyCompany();
        return $this->response($debets);
    }

    public function getDebetReportDayByCompany()
    {
        $debets = $this->debetService->getDebetReportDayByCompany();
        return $this->response($debets);
    }

    public function getDebetByContractIdNoPayed(DebetByContractIdRequest $request)
    {
        $debets = $this->debetService->getDebetByContractIdNoPayed($request->contract_id);
        return $this->response($debets);
    }

    public function getDebetByContractIdPayed(DebetByContractIdRequest $request)
    {
        $debets = $this->debetService->getDebetByContractIdPayed($request->contract_id);
        return $this->response($debets);
    }

    public function getJournal()
    {
        $debets = $this->debetService->getJournal();
        return $this->response($debets);
    }

    public function getMyAllDebetToNow()
    {
        $debets = $this->debetService->getMyAllDebetToNow();
        return $this->response($debets);
    }


    public function updateDebet(UpdateDebetRequest $request)
    {
        $debet = $this->debetService->updateDebet($request->id, $request->pay);
        return $this->response($debet);
    }

    public function getMyAllDebetBeetwen(DebetBeetwenRequest $request)
    {
        $debets = $this->debetService->getMyAllDebetBeetwen($request->start, $request->end);
        return $this->response($debets);
    }


}
