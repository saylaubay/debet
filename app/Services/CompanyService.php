<?php


namespace App\Services;


use App\Http\Requests\CompanyUpdateRequest;
use App\Models\ApiResponse;

class CompanyService extends BaseService
{

    public function getAllCompanies()
    {
//        dd("test");
        $coms = $this->companyRepository->getAllCompanies();
        return new ApiResponse('Companylar dizimi:', true, $coms);
    }

    public function getCompanyById($id)
    {
        $company = $this->companyRepository->findById($id);

        if ($company == null){
            return new ApiResponse("Bunday id li company tabilmadi!!!", false, $company);
        }else{
            return new ApiResponse("Company : ", true, $company);
        }
    }

    public function blockCompany($id)
    {
        $company = $this->companyRepository->findById($id);
        if ($company == null){
            return new ApiResponse("Bunday id li company tabilmadi!!!", false, $company);
        }
        $company->active = false;
        $company->save();
        return new ApiResponse("Company bloklandi!!!", true, $company);
    }

    public function unBlockCompany($id)
    {
        $company = $this->companyRepository->findById($id);
        if ($company == null){
            return new ApiResponse("Bunday id li company tabilmadi!!!", false, $company);
        }
        $company->active = true;
        $company->save();
        return new ApiResponse("Company bloklantan shig`arildi!!!", true, $company);
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
