<?php


namespace App\Repostirories\Interfaces;


interface DebetRepositoryInterface
{

    public function saveInContract($month_name, $summa, $contract_id, $pay_date);

    public function findFirst();

    public function saveAll($debets);

    public function save($debet);

    public function findById($id);

    public function deleteById($id);

    public function findAll();

    public function findByContractId($contract_id);

    public function findByContractIdAndId($contract_id, $id);

    public function findByContract_Worker_CompanyAndContract_Worker_CompanyActive($contract_worker_company, $contract_worker_company_active);

    public function findByContract_Worker_CompanyAndCreatedAtBetweenAndContract_Worker_CompanyActive($contract_worker_company, $created_at, $created_at2, $contract_worker_company_active);

    public function findByContract_Worker_IdAndContract_IdAndPaid($contract_worker_id, $contract_id, $paid);

    public function findByContract_Worker_IdAndUpdatedAtBetweenAndContract_Worker_Company_ActiveAndPaid($contract_worker_id, $updated_at, $updated_at2, $contract_worker_company_active, $paid);

    public function findByPaidAndContract_Worker_IdOrderByPayDate($paid, $contract_worker_id);

    public function findByPaidAndContract_Worker_IdAndPayDateBetweenOrderByPayDate($paid, $contract_worker_id, $created_at, $created_at2);


}
