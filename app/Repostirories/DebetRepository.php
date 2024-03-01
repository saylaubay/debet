<?php


namespace App\Repostirories;


use App\Models\Company;
use App\Models\Contract;
use App\Models\Debet;
use App\Repostirories\Interfaces\DebetRepositoryInterface;

class DebetRepository implements DebetRepositoryInterface
{


    public function saveAll($debets)
    {
        // TODO: Implement saveAll() method.
    }

    public function save($debet)
    {
        return Debet::create([
           'month_name'=>$debet->month_name,
           'summa'=>$debet->summa,
           'contract_id'=>$debet->contract_id,
        ]);
    }

    public function findById($id)
    {
        return Debet::find($id);
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }

    public function findAll()
    {
        return Debet::all();
    }

    public function findByContractId($contract_id)
    {
        return Debet::where('contract_id', $contract_id)->get();
    }

    public function findByContractIdAndId($contract_id, $id)
    {
        //findByContractIdAndId
        return Debet::where('contract_id', $contract_id)->where('id', $id)->first();
    }
                    //findByContract_Worker_CompanyAndContract_Worker_CompanyActive
    public function findByContract_Worker_CompanyAndContract_Worker_CompanyActive($contract_worker_company, $contract_worker_company_active)
    {
        $company = Company::find($contract_worker_company);
        if ($company == null){
            return null;
        }
        $debets = Debet::
        join('contracts', 'contracts.id', '=', 'debets.contract_id')->
        join('users', 'contracts.user_id', '=', 'users.id')->
        join('companies', 'companies.id', '=', 'users.company_id')->
            where('users.company_id', $contract_worker_company)->
            where('companies.active', $contract_worker_company_active)->
        get();
        return $debets;
    }

    public function findByContract_Worker_CompanyAndCreatedAtBetweenAndContract_Worker_CompanyActive($contract_worker_company, $created_at, $created_at2, $contract_worker_company_active)
    {
        // TODO: Implement findByContract_Worker_CompanyAndCreatedAtBetweenAndContract_Worker_CompanyActive() method.
    }
                  //findByContract_Worker_IdAndContract_IdAndPaid
    public function findByContract_Worker_IdAndContract_IdAndPaid($contract_worker_id, $contract_id, $paid)
    {
        return Debet::where('contract_id', $contract_id)->
            where('paid', false)->
            join('contracts', 'contracts.id', '=', 'debets.contract_id')->
//            join('users', 'users.id', '=', 'contracts.user_id')->
            where('contracts.user_id', $contract_worker_id)->
        get();
    }

    public function findByContract_Worker_IdAndUpdatedAtBetweenAndContract_Worker_Company_ActiveAndPaid($contract_worker_id, $updated_at, $updated_at2, $contract_worker_company_active, $paid)
    {
        return Debet::where('paid', $paid)->
//            where('updated_at', )
            join('contracts', 'contracts.id', '=', 'debets.contract_id')->
            join('users', 'contracts.user_id', '=', 'users.id')->
            join('companies', 'companies.id', '=', 'users.company_id')->
            where([
            ['contracts.user_id', '=', $contract_worker_id],
            ['debets.updated_at', '>=', $updated_at],
            ['debets.updated_at', '<=', $updated_at2],
            ['companies.active', '=', $contract_worker_company_active],
        ])->get();
    }
                  //findByPaidAndContract_Worker_IdOrderByPayDate
    public function findByPaidAndContract_Worker_IdOrderByPayDate($paid, $contract_worker_id)
    {
        return Debet::where('paid', $paid)->
            join('contracts', 'contracts.id', '=', 'debets.contract_id')->
            where('contracts.user_id', $contract_worker_id)->
        orderBy('pay_date')->
            get();
    }
                    //findByPaidAndContract_Worker_IdOrderByPayDate
    public function findByPaidAndContract_Worker_IdAndPayDateBetweenOrderByPayDate($paid, $contract_worker_id, $created_at, $created_at2)
    {
        return Debet::where('paid', $paid)->
//            where('debets.created_at', '>=', $created_at)->
//            where('debets.created_at', '<=', $created_at2)->
        join('contracts', 'contracts.id', '=', 'debets.contract_id')->
        where([
            ['contracts.user_id', '=', $contract_worker_id],
            ['debets.pay_date', '>=', $created_at],
            ['debets.pay_date', '<=', $created_at2],
        ])->
//        orderBy('pay_date')->
        get();
    }

    public function findFirst()
    {
        return Debet::first();
    }

    public function saveInContract($month_name, $summa, $contract_id, $pay_date)
    {
       return Debet::create([
            'month_name' => $month_name,
            'summa' => $summa,
            'contract_id' => $contract_id,
            'pay_date' => $pay_date,
        ]);
    }
}
