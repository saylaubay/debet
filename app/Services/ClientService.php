<?php


namespace App\Services;


use App\Http\Resources\ClientResource;
use App\Models\ApiResponse;
use App\Models\Client;
use Illuminate\Http\Request;
use function Sodium\add;
use function Symfony\Component\Console\Helper\cloneInputStream;

class ClientService extends BaseService
{



    public function addClient($request)
    {
        $clientBool = $this->clientRepository->existsByPhone($request->phone);
        if ($clientBool == null){
            return new ApiResponse('Bunday klient bazada bar!', false);
        }
        $client = $this->clientRepository->save($request->first_name, $request->last_name, $request->phone, $request->company_id);
        return new ApiResponse('Klient bazaga saqlandi!', true, $client);
    }

    public function getAll()
    {
        $clients = $this->clientRepository->findAll();
        return new ApiResponse("Client list : ", true, ClientResource::collection($clients));
    }

    public function findById($id)
    {
        $client = $this->clientRepository->findById($id);
        if ($client == null){
            return new ApiResponse("Bunday id li client bazada tabilmadi!!!", false);
        }
        return new ApiResponse("Client : ", true, new ClientResource($client));
    }

    public function update($id, $request)
    {
        $client = $this->clientRepository->update($id, $request);
        if (!$client){
            return new ApiResponse("Bunday client bazadan tabilmadi!!!", false);
        }
        return new ApiResponse("Client updated!!!", true);
    }

    public function destroy($id)
    {
        $client = $this->clientRepository->deleteById($id);
        if ($client){
            return new ApiResponse("Client o`shirildi!!!", true);
        }
        return new ApiResponse("Bunday id li client tabilmadi!!!", false);
    }

    public function getAllMyClient($id)
    {
        $clients = [];
        $contracts = $this->contractRepository->getAllByUserId($id);
        for ($x = 0; $x < $contracts->count(); $x++) {
            $clients[$x] = $contracts[$x];
        }
        return new ApiResponse("My Clients : ", true, ClientResource::collection($clients));
    }

    public function getClientsByUserId($id)
    {
        $clients = [];
        $contracts = $this->contractRepository->getAllByUserId($id);
        for ($x = 0; $x < $contracts->count(); $x++) {
            $clients[$x] = $contracts[$x];
        }
        return new ApiResponse("Clients : ", true, ClientResource::collection($clients));
    }


}
