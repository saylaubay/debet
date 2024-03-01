<?php


namespace App\Repostirories;


use App\Models\Client;
use App\Models\Contract;
use App\Models\User;
use App\Repostirories\Interfaces\ContractRepositoryInterface;

class ContractRepository implements ContractRepositoryInterface
{

    public function saveAll()
    {
        // TODO: Implement saveAll() method.
    }

    public function save($contract)
    {
        $contract =  Contract::create([
            'product_name'=>$contract->product_name,
            'product_id'=>$contract->product_id,
            'user_id'=>$contract->user_id,
            'price'=>$contract->price,
            'client_id'=>$contract->client_id,
            'part'=>$contract->part,
            'percent'=>$contract->percent,
        ]);
//        if ($contract != null){
//            $contract->created_at = $current_time;
            $contract->save();
//        }
        return $contract;
    }

    public function findById($id)
    {
        return Contract::find($id);
    }

    public function deleteById($id)
    {
        return Contract::destroy($id);
    }

    public function findByClient_Phone($clent_phone)
    {
        $contract = Contract::join('clients', 'clients.id', '=', 'contracts.client_id')->where('phone', $clent_phone)->get();
        return $contract;
    }

    public function findByClient_PhoneContainingAndWorker_Company_IdAndClient_Company_IdAndWorker_Id($client_phone, $worker_company_id, $client_company_id, $worker_id)
    {
        // TODO: Implement findByClient_PhoneContainingAndWorker_Company_IdAndClient_Company_IdAndWorker_Id() method.
    }

    public function findByEnabledAndClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt($active, $client_company_id, $worker_company_id, $worker_id)
    {
        return Contract::where('user_id', $worker_id)->
        join('clients', 'clients.id','=','contracts.id')->
            join('users', 'users.id','=','contracts.user_id')->
//            where([
//                ['clients.company_id', $client_company_id],
//                ['users.company_id', $worker_company_id],
//                ['contracts.active', $active],
//        ])->
            where('clients.company_id', $client_company_id)->
            where('users.company_id', $worker_company_id)->
            where('contracts.active', $active)->
            orderBy('contracts.created_at','desc')->
        get();
    }
                  //findByWorker_CompanyAndCreatedAtBetweenAndWorker_CompanyActive
    public function findByWorker_CompanyAndCreatedAtBetweenAndWorker_CompanyActive($worker_company_id, $created_at, $created_at2, $worker_company_active)
    {
        return Contract::
//        whereBetween('created_at', [$start, $end])->
        join('users', 'users.id', '=', 'contracts.user_id')->
        join('companies', 'companies.id', '=', 'users.company_id')->
        where([
            ['companies.id', $worker_company_id],
            ['companies.active', $worker_company_active],
            ['contracts.created_at', '>=', $created_at],
            ['contracts.created_at', '<=', $created_at2],
        ])->
        get();
    }

    public function findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive($worker_id, $created_at, $created_at2, $worker_company_active)
    {
        return Contract::where('user_id', $worker_id)->
//        where('created_at', '>=', $created_at)->
//        where('created_at', '<=', $created_at2)->
//        whereBetween('created_at', [$created_at, $created_at2])->
            join('users', 'users.id', '=', 'contracts.user_id')->
            join('companies', 'companies.id', '=', 'users.company_id')->
//            where('companies.active', '=', $worker_company_active)->
            where([
                ['companies.active', '=', $worker_company_active],
            ['contracts.created_at', '>=', $created_at],
            ['contracts.created_at', '<=', $created_at2],
        ])->
            get();
    }

    public function findByWorkerId($worker_id)
    {
        return Contract::where('user_id', $worker_id)->get();
    }

    public function findByWorker_CompanyId($worker_company_id)
    {
        $contract = Contract::join('users', 'users.id', '=', 'contracts.user_id')->where('company_id',$worker_company_id)->get();
        return $contract;
    }

    public function findByClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt($client_company_id, $worker_company_id, $worker_id)
    {
        $cons =  Contract::where('user_id', $worker_id)->
            join('clients','clients.id', '=', 'contracts.user_id')->
            join('users', 'users.id', '=', 'contracts.user_id')->
            where('clients.company_id', $client_company_id)->
            where('users.company_id', $worker_company_id)->
//            where([
//            ['clients.company_id', '=', $client_company_id],
//            ['users.company_id', '=', $worker_company_id],
//                ])->
//            orderBy('created_at','desc')->
        get();
//        dd($cons);
        return $cons;
    }


    public function findAll()
    {
        return Contract::all();
    }

    public function getAllByUserId($id)
    {
        $contracts = Contract::where('user_id', $id)->get();
        return $contracts;
    }
//findByClient_PhoneContainingAndWorker_Company_IdAndClient_Company_IdAndWorker_Id
    public function findByPhone($phone, $worker_company_id, $client_company, $worker_id)
    {
        $contract = Contract::where('user_id', 1)->
        join('clients','clients.id','=','contracts.user_id')->
        join('users', 'users.id', '=', 'contracts.user_id')->
        where([
            ['clients.phone', 'LIKE', $phone],
            ['clients.company_id', '=', 1],
            ['users.company_id', '=', 1],
//                ['users.id', '=', 1],
        ])->get();
        return $contract;
//        $client = Client::where('phone', 'LIKE', '%'.$phone.'%')->first();
//        $user = User::where('company_id', '')->get();
//
//        $cons = Contract::join('users','contracts.user_id', '=', 'users.id')->get();
//        dd($cons);
//        if (!$client){
//            return null;
//        }


    }
}
