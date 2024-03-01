<?php


namespace App\Services;


use App\Models\ApiResponse;
use App\Models\Client;
use Illuminate\Http\Request;
use function Sodium\add;
use function Symfony\Component\Console\Helper\cloneInputStream;

class ClientService extends BaseService
{



    public function addClient($request)
    {
        $client = $this->clientRepository->existsByPhone($request->phone);
        if ($client == null){
            return new ApiResponse('Bunday klient bazada bar!', false);
        }
        return new ApiResponse('Klient bazaga saqlandi!', true, $client);
    }

    public function getAll()
    {
        $clients = $this->clientRepository->findAll();
        return new ApiResponse("Client list : ", true, $clients);
    }

    public function findById($id)
    {
        $client = $this->clientRepository->findById($id);
        if ($client == null){
            return new ApiResponse("Bunday id li client bazada tabilmadi!!!", false);
        }
        return new ApiResponse("Client : ", true, $client);
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
        return new ApiResponse("My Clients : ", true, $clients);
    }

    public function getClientsByUserId($id)
    {
        $clients = [];
        $contracts = $this->contractRepository->getAllByUserId($id);
        for ($x = 0; $x < $contracts->count(); $x++) {
            $clients[$x] = $contracts[$x];
        }
        return new ApiResponse("Clients : ", true, $clients);
    }


}
