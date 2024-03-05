<?php


namespace App\Repostirories;


use App\Models\ApiResponse;
use App\Models\Client;
use App\Models\Company;
use App\Repostirories\Interfaces\ClientRepositoryInterface;
use Ramsey\Uuid\Type\Integer;

class ClientRepository implements ClientRepositoryInterface
{

    public function findByCreatedByOrderByFirstName($id){
//        $client = Client::find($id);
//        if ($client == null){
//            return false;
//        }
        $clients = Client::query()->where('id', $id)->orderBy('first_name','asc')->get();
//        dd($client);
        return $clients;
    }

    public function existsByPhone($phone)
    {
        $client = Client::where('phone', $phone)->first();
        if ($client){
            return null;
//            return new ApiResponse('Bunday klient bazada bar!', false);
        }

        return $client;
    }

    public function existsByPhoneAndCreatedBy($phone, $id)
    {
        // TODO: Implement existsByPhoneAndCreatedBy() method.
    }

    public function findAllByOrderByFirstName()
    {
        // TODO: Implement findAllByOrderByFirstName() method.
    }


    public function findAll()
    {
        return Client::all();
    }

    public function findById($id)
    {
        $client = Client::find($id);
        return $client;
    }

    public function update($id, $newClient)
    {
        $client = Client::find($id);
        if ($client == null){
            return false;
        }
        $client->first_name = $newClient->first_name;
        $client->last_name = $newClient->last_name;
//        $client->phone = $newClient->phone;
        $client->company_id = $newClient->company_id;
        $client->save();
        return true;
    }

    public function findByPhone($phone)
    {
        $client = Client::where('phone', $phone)->get();
        return $client;
    }

    public function deleteById($id)
    {
        $client = Client::where('id', $id)->exists();
        if (!$client){
            return false;
        }
        Client::destroy($id);
        return true;
    }

    public function save($first_name, $last_name, $phone, $company_id)
    {
        $client =Client::create([
            "first_name"=>$first_name,
            "last_name"=>$last_name,
            "phone"=>$phone,
            "company_id"=>$company_id,
        ]);
        return $client;
    }
}
