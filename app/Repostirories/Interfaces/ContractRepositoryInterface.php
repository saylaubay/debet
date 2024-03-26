<?php


namespace App\Repostirories\Interfaces;


interface ContractRepositoryInterface
{

    public function findByPhone($phone, $worker_company_id, $client_company, $worker_id);

    public function getAllByUserId($id);

    public function findAll();

    public function save($contract);

    public function findById($id);

    public function deleteById($id);

    public function findByClient_Phone($clent_phone);

    public function findByEnabledAndClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt($active, $client_company_id, $worker_company_id, $worker_id);

    public function findByWorker_CompanyAndCreatedAtBetweenAndWorker_CompanyActive($worker_company_id, $created_at, $created_at2, $worker_company_active);

    public function findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive($worker_id, $created_at, $created_at2, $worker_company_active);

    public function findByWorkerId($worker_id);

    public function findByWorker_CompanyId($worker_company_id);

    public function findByClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt($client_company_id, $worker_company_id, $worker_id);


}
