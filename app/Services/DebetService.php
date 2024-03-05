<?php


namespace App\Services;


use App\Http\Resources\DebetResource;
use App\Models\ApiResponse;
use Carbon\Carbon;
use function Symfony\Component\HttpFoundation\Session\Storage\start;

class DebetService extends BaseService
{



    public function getAll()
    {
        $debets = $this->debetRepository->findAll();
        return new ApiResponse("Debet list : ", true, DebetResource::collection($debets));
    }

    public function getOne($id)
    {
        $debet = $this->debetRepository->findById($id);
        if ($debet == null){
            return new ApiResponse("Bunday id li debet tabilmadi!!!", false);
        }
        return new ApiResponse("Debet : ", true, new DebetResource($debet));
    }

    public function destroy($id)
    {
        $this->debetRepository->deleteById($id);
        return new ApiResponse("Debet deleted !!!", true);
    }

    public function save($request)
    {
        $isHave = $this->contractRepository->findById($request->contract_id);
        if ($isHave == null){
            return new ApiResponse("Bunday d li contract tabilmadi!!!", false);
        }
        $debet = $this->debetRepository->save($request);
        return new ApiResponse("Debet saved!!!", true, new DebetResource($debet));
    }

    public function getAllDebetByMyCompany()
    {
        $debets = $this->debetRepository->findByContract_Worker_CompanyAndContract_Worker_CompanyActive(auth()->user()->id, true);
//        $debets = $this->debetRepository->findByContract_Worker_CompanyAndContract_Worker_CompanyActive(1, true);
        if ($debets == null){
            return new ApiResponse("Bunday id li contract tabilmadi!!!", false);
        }
        return new ApiResponse("Debet list : ", true, DebetResource::collection($debets));
    }

    public function getDebetReportDayByCompany()
    {
        $start = Carbon::create(Carbon::now()->year(), Carbon::now()->month, Carbon::now()->day, 0, 0, 1);
        $end = Carbon::create(Carbon::now()->year(), Carbon::now()->month, Carbon::now()->day, 23, 59, 59);

        $debets = $this->debetRepository->findByContract_Worker_CompanyAndCreatedAtBetweenAndContract_Worker_CompanyActive(
            auth()->user()->company_id,
            $start,
            $end,
            true
        );

//        $debets = $this->debetRepository->findByContract_Worker_CompanyAndCreatedAtBetweenAndContract_Worker_CompanyActive(
//            1,
//            $start,
//            $end,
//            true
//        );
        return new ApiResponse("Company boyinsha ku'nlik esabat!!!", true, DebetResource::collection($debets));
    }

    public function getDebetByContractIdNoPayed($contract_id)
    {
        //findByContract_Worker_IdAndContract_IdAndPaid
        $debets = $this->debetRepository->findByContract_Worker_IdAndContract_IdAndPaid(auth()->user()->id, $contract_id, false);
//        $debets = $this->debetRepository->findByContract_Worker_IdAndContract_IdAndPaid(1, $contract_id, false);
        return new ApiResponse("Debet list : ", true, DebetResource::collection($debets));
    }

    public function getDebetByContractIdPayed($contract_id)
    {
        //findByContract_Worker_IdAndContract_IdAndPaid
        $debets = $this->debetRepository->findByContract_Worker_IdAndContract_IdAndPaid(auth()->user()->id, $contract_id, true);
//        $debets = $this->debetRepository->findByContract_Worker_IdAndContract_IdAndPaid(1, $contract_id, true);
        return new ApiResponse("Debet list : ", true, DebetResource::collection($debets));
    }

    public function setPay($request)
    {
        //findByContractIdAndId
        $debet = $this->debetRepository->findByContractIdAndId($request->contract_id, $request->debet_id);
//        dd($debet);
        $debet->paid = true;
        $debet->save();
        $this->checkDebetList($request->contract_id);
        return new ApiResponse("To'lendi!!!", true);
    }

    public function checkDebetList($contract_id)
    {
        $count = 0;
        //findByContractId
        $debets = $this->debetRepository->findByContractId($contract_id);
        foreach ($debets as $debet) {
            if (!$debet->paid){
                $count++;
            }
        }
        if ($count == 0){
            $contract = $this->contractRepository->findById($contract_id);
            $contract->active = true;
            $contract->save();
        }
    }

    public function getJournal()
    {
        //findByPaidAndContract_Worker_IdOrderByPayDate
//        $start = Carbon::create(Carbon::now()->year, Carbon::now()->month+1, 1, 0, 0, 1);
//        $end = Carbon::create(Carbon::now()->year, Carbon::now()->month+1, Carbon::now()->daysInMonth, 23, 59, 59);
        $list = $this->debetRepository->findByPaidAndContract_Worker_IdOrderByPayDate(false, auth()->user()->id);

//        $list = $this->debetRepository->findByPaidAndContract_Worker_IdOrderByPayDate(false, 2);
        return new ApiResponse("Jurnal listi", true, DebetResource::collection($list));
    }

    public function getMyAllDebetToNow()
    {
        //findByContract_Worker_IdAndUpdatedAtBetweenAndContract_Worker_Company_ActiveAndPaid
        //findByContract_Worker_IdAndUpdatedAtBetweenAndContract_Worker_Company_ActiveAndPaid

//        $firstDebet = $this->debetRepository->findFirst();
        $start = auth()->user()->created_at;
//        $start = $firstDebet->created_at;
        $end = Carbon::now();

        $debets = $this->debetRepository->findByContract_Worker_IdAndUpdatedAtBetweenAndContract_Worker_Company_ActiveAndPaid(
            auth()->user()->id,
            $start,
            $end,
            true,
            false
        );
//        $debets = $this->debetRepository->findByContract_Worker_IdAndUpdatedAtBetweenAndContract_Worker_Company_ActiveAndPaid(
//            2,
//            $start,
//            $end,
//            true,
//            false
//        );
        return new ApiResponse("Contract list", true, DebetResource::collection($debets));
    }

    public function updateDebet($id, $pay)
    {
        $debet = $this->debetRepository->findById($id);
        if ($debet == null){
            return new ApiResponse("Bunday id li debet tabilmadi!!!", false);
        }
        $debet->paid = $pay;
        $debet->save();
        $this->checkDebetList($debet->contract_id);
        return new ApiResponse("Debet updated !!!", true, new DebetResource($debet));
    }

    public function getMyAllDebetBeetwen($start, $end)
    {
//        if (start.equals("dan") || start.equals("")) {
//            start = user.getCreatedAt().getDate() + "/" + user.getCreatedAt().getMonth() + "/" + user.getCreatedAt().getYear();
//            System.out.println(start);
//        }
//        $user = auth()->user();
        $count = 0;
        if ($start == "dan" || $start == ""){
            $count++;
            $created_at = Carbon::create(auth()->user()->created_at->year, auth()->user()->created_at->month, auth()->user()->created_at->day, 0, 0, 1);
        }
        if ($count == 0){
            $created_at = Carbon::create(substr($start,6,4), substr($start,3,2), substr($start,0,2),0,0,1);
        }
        $created_at2 = Carbon::create(substr($end,6,4), substr($end,3,2), substr($end,0,2),23,59,59);

        $debets = $this->debetRepository->findByContract_Worker_IdAndUpdatedAtBetweenAndContract_Worker_Company_ActiveAndPaid(
            auth()->user()->id,
            $created_at,
            $created_at2,
            true,
            true
        );
//        $debets = $this->debetRepository->findByContract_Worker_IdAndUpdatedAtBetweenAndContract_Worker_Company_ActiveAndPaid(
//            2,
//            $start,
//            $end,
//            true,
//            true
//        );
        return new ApiResponse("Debet list beetwen by date", true, DebetResource::collection($debets));
    }


}
