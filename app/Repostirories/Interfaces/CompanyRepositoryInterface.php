<?php


namespace App\Repostirories\Interfaces;


use App\Models\Client;
use Carbon\Traits\Timestamp;

interface CompanyRepositoryInterface
{

//    public function getAraliq(Timestamp Time);

    public function save($company);

    public function findById($id);

    public function deleteById($id);

    public function getAllCompanies();


}
