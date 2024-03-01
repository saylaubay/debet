<?php


namespace App\Repostirories;


use App\Models\Company;
use App\Repostirories\Interfaces\CompanyRepositoryInterface;

class CompanyRepository implements CompanyRepositoryInterface
{

    public function save($company)
    {
        $com = Company::where('name', $company)->exists();
        if ($com){
            return false;
        }
        Company::create([
            'name'=>$company,
        ]);
        return true;
    }

    public function findById($id)
    {
        return Company::find($id);
    }

    public function deleteById($id)
    {
        $company = Company::where('id', $id)->exists();
        if (!$company){
            return false;
        }
        Company::destroy($id);
        return true;
    }

    public function getAllCompanies()
    {
        return Company::all();
    }
}
