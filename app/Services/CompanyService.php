<?php


namespace App\Services;


use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Models\ApiResponse;
use App\Models\Company;

class CompanyService extends BaseService
{

    public function hammesi()
    {
        return new ApiResponse('Companylar dizimi:', true, Company::all());
    }

    public function getAllCompanies()
    {
        $companies = $this->companyRepository->getAllCompanies();
        return new ApiResponse('Companylar dizimi:', true, CompanyResource::collection($companies));
    }

    public function getCompanyById($id)
    {
        $company = $this->companyRepository->findById($id);

        if ($company == null){
            return new ApiResponse("Bunday id li company tabilmadi!!!", false);
        }else{
            return new ApiResponse("Company : ", true, new CompanyResource($company));
        }
    }

    public function blockCompany($id)
    {
        $company = $this->companyRepository->findById($id);
        if ($company == null){
            return new ApiResponse("Bunday id li company tabilmadi!!!", false);
        }
        $company->active = false;
        $company->save();
        return new ApiResponse("Company bloklandi!!!", true, new CompanyResource($company));
    }

    public function unBlockCompany($id)
    {
        $company = $this->companyRepository->findById($id);
        if ($company == null){
            return new ApiResponse("Bunday id li company tabilmadi!!!", false);
        }
        $company->active = true;
        $company->save();
        return new ApiResponse("Company bloklantan shig`arildi!!!", true, new CompanyResource($company));
    }

    public function add($name)
    {
        $company = $this->companyRepository->save($name);

        if (!$company){
            return new ApiResponse("Bunday compnay name bazada bar!!!", false);
        }
        return new ApiResponse("Compn=any bazag'a saqlandi!!!", true);
    }

    public function update($id, CompanyUpdateRequest $request)
    {
        $company = $this->companyRepository->findById($id);
        if ($company == null){
            return new ApiResponse("Bunday id li company tabilmadi!!!", false);
        }
        $company->name = $request->name;
        if ($request->active == true ||$request->active == false) {
            $company->active = $request->active;
        }
        $company->save();

        return new ApiResponse("Company jan'alandi!!!", true);
    }

    public function deleteById($id)
    {
        $company = $this->companyRepository->deleteById($id);
        if ($company){
            return new ApiResponse("Company o`shirildi!!!", true);
        }
        return new ApiResponse("Bunday id li company tabilmadi!!!", false);
    }

}
