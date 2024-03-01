<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyBlockRequest;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;

class CompanyController extends BaseController
{


    public function index()
    {
        $companies = $this->companyService->getAllCompanies();
        return $this->response($companies);
    }

    public function store(CompanyStoreRequest $request)
    {
        $store = $this->companyService->add($request->name);
        return $this->response($store);
    }

    public function show($id)
    {
        $company = $this->companyService->getCompanyById($id);
        return $this->response($company);
    }

    public function update(CompanyUpdateRequest $request, $id)
    {
        $update = $this->companyService->update($id, $request);
        return  $this->response($update);
    }

    public function destroy($id)
    {
        $company = $this->companyService->deleteById($id);
        return $this->response($company);
    }

    public function blockCompany(CompanyBlockRequest $request)
    {
        $update = $this->companyService->blockCompany($request->id);
        return  $this->response($update);
    }

    public function unBlockCompany(CompanyBlockRequest $request)
    {
        $update = $this->companyService->unBlockCompany($request->id);
        return  $this->response($update);
    }




}
