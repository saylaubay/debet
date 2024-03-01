<?php


namespace App\Services;


use App\Http\Requests\ContractByNumberRequest;
use App\Models\ApiResponse;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Debet;
use App\Models\DebetDto;
use App\Models\Product;
use App\Models\ResponseData;
use App\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Carbon;
use Spatie\FlareClient\Api;
use function Symfony\Component\Console\Input\equals;
use function Symfony\Component\HttpFoundation\Session\Storage\start;

class ContractService extends BaseService
{

    public function getAll()
    {
        $contracts = $this->contractRepository->findAll();
        return new ApiResponse("Contractlar dizimi : ", true, $contracts);
    }

    public function getOne($id)
    {
        $contract = $this->userRepository->findById($id);
        if ($contract == null) {
            return new ApiResponse("Bunday id li contract tabilmadi!!!", false);
        }
        return new ApiResponse("Contract : ", true, $contract);
    }

    public function save($request)
    {
        $prod = $this->productRepository->findById($request->product_id);
        $user = $this->userRepository->findById($request->user_id);
        $client = $this->clientRepository->findById($request->client_id);
//        $prod = Product::find($request->product_id);
//        $user = User::find($request->user_id);
//        $client = Client::find($request->client_id);
        if ($prod == null || $user == null || $client == null) {
            return new ApiResponse("Mag'liwmatlar qa'telikler bar!!!", false);
        }

        $savedContract = $this->contractRepository->save($request);

        $currentTime = Carbon::now();

        $day = $currentTime->day;
        $month = $currentTime->month;
        $year = $currentTime->year;

        $sDay = $savedContract->created_at->day;
        $sMonth = $savedContract->created_at->month + 1;
        $sYear = $savedContract->created_at->year;

        for ($x = 0; $x < $request->part; $x++) {
            $monthName = $currentTime->setMonth($sMonth)->monthName;
            $sane = $sDay . " - " . $monthName . " - " . $sYear;
//            $dTimestamp = Carbon::create($savedContract->created_at->year, $savedContract->created_at->month, $savedContract->created_at->day);
            $dTimestamp = Carbon::create($sYear, $sMonth, $sDay);

            $this->debetRepository->saveInContract(
                $day . " - " . $monthName . " - " . $year,
                $request->price / 100 * $savedContract->percent + $request->price / $request->part,
                $savedContract->id,
                $dTimestamp
            );

            $bool = true;
            if ($month == 12) {
                $year++;
                $month = 1;
                $bool = false;
                $sMonth = 1;
                $sYear++;
            }
            if ($bool) {
                $month++;
                $sMonth++;
            }
        }
        return new ApiResponse("Contract saqlandi!!!", true, $savedContract);
    }

    public function addContractOld($request)
    {
        $prod = $this->productRepository->findById($request->product_id);
        $user = $this->userRepository->findById($request->user_id);
        $client = $this->clientRepository->findById($request->client_id);
//        $prod = Product::find($request->product_id);
//        $user = User::find($request->user_id);
//        $client = Client::find($request->client_id);
        if ($prod == null || $user == null || $client == null) {
            return new ApiResponse("Mag'liwmatlar qa'telikler bar!!!", false);
        }

        $date = $request->oldDate;
//        substr("25.02.2024",0,2)."<br>";
//        echo substr("25.02.2024",3,2)."<br>";
//        echo substr("25.02.2024",6,4)
//        dd(substr($date,6,4));

//        $currentTime = Carbon::create(substr($date,0,2),substr($date,3,2), substr($date,6,4));
        $currentTime = Carbon::create(substr($date, 6, 4), substr($date, 3, 2), substr($date, 0, 2));

        $day = $currentTime->day;
        $month = $currentTime->month;
        $year = $currentTime->year;

        $currentTime->setHour(8);
        $currentTime->setMinute(0);
        $currentTime->setSecond(1);

//        dd($day . " - " . $month ." - " . $year);

        $savedContract = $this->contractRepository->save($request, $currentTime);

        $payedPart = $request->payedPart;
        $count = 1;

        $sDay = $savedContract->created_at->day;
        $sMonth = $savedContract->created_at->month + 1;
        $sYear = $savedContract->created_at->year;

        for ($x = 0; $x < $request->part; $x++) {
            $monthName = $currentTime->setMonth($sMonth)->monthName;
            $sane = $sDay . " - " . $monthName . " - " . $sYear;
//            $dTimestamp = Carbon::create($savedContract->created_at->year, $savedContract->created_at->month, $savedContract->created_at->day);
            $dTimestamp = Carbon::create($sYear, $sMonth, $sDay);

            $debet = $this->debetRepository->saveInContract(
                $day . " - " . $monthName . " - " . $year,
                $request->price / 100 * $savedContract->percent + $request->price / $request->part,
                $savedContract->id,
                $dTimestamp
            );
//            $debet = Debet::create([
//                'month_name' => $day . " - " . $monthName . " - " . $year,
//                'summa' => $request->price / 100 * $savedContract->percent + $request->price / $request->part,
//                'contract_id' => $savedContract->id,
//                'pay_date' => $dTimestamp,
//            ]);
//            $debets[$x] = $deb;

//            if (count <=payedPart){
//                debet.setPaid(true);
//            }

            if ($count <= $payedPart) {
//                dd($debet);
                $debet->paid = true;
                $debet->save();
            }

            $bool = true;
            if ($month == 12) {
                $year++;
                $month = 1;
                $bool = false;
                $sMonth = 1;
                $sYear++;
            }
            if ($bool) {
//                $month++;
                $sMonth++;
            }
            $count++;
        }
        return new ApiResponse("Old contract saved!!!", true);
    }

    public function destroy($id)
    {
        $con = $this->contractRepository->findById($id);
//        $con = Contract::find($id);
        if ($con == null) {
            return new ApiResponse("Bunday id li contract tabilmadi!!!", false);
        }
        $this->contractRepository->deleteById($id);
        return new ApiResponse("Contract o'shirildi!!!", true);
    }

    public function byNumber($client_phone)
    {
//        $contracts = $this->contractRepository->findByPhone($client_phone, auth()->user()->company_id, auth()->user()->company_id,auth()->user()->id);
        $contracts = $this->contractRepository->findByPhone($client_phone, 1, 2, 1);
        if ($contracts == null || !$contracts) {
            return new ApiResponse("Mag'liwmatlarda qa'telik bar!!!", false);
        }
        return new ApiResponse("Contract list : ", true, $contracts);
    }

    public function calc($request)
    {
        $resData = new ResponseData(
            $request->part * 1,
            $request->summa / 100 * $request->percent * $request->part,
            $request->summa / 100 * $request->percent + $request->summa / $request->part,
            $request->summa + $request->summa / 100 * $request->percent * $request->part,
            $request->summa / 100 * $request->percent
        );
        return new ApiResponse("Calculated : ", true, $resData);
    }

    public function findByClientPhone($request)
    {
        //findByClient_Phone
        $contracts = $this->contractRepository->findByClient_Phone($request->phone);
        return new ApiResponse("Contract list : ", true, $contracts);
    }

    public function getMyContract()
    {
        $contracts = $this->contractRepository->findByWorkerId(auth()->user()->id);
        return new ApiResponse("My contract list : ", true, $contracts);
    }

    public function getAllContractByNoPayed()
    {
        $contracts = $this->contractRepository->findByEnabledAndClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt(
            false,
            auth()->user()->company_id,
            auth()->user()->company_id,
            auth()->user()->id
        );
//        $contracts = $this->contractRepository->findByEnabledAndClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt(
//            false,
//            1,
//            1,
//            1
//        );
        return new ApiResponse("Get all contracts no payed!!!", true, $contracts);
    }

    public function getAllContractByPayed()
    {
//        $contracts = $this->contractRepository->findByEnabledAndClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt(
//            true,
//            1,
//            1,
//            1
//        );
        $contracts = $this->contractRepository->findByEnabledAndClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt(
            true,
            auth()->user()->company->id,
            auth()->user()->company->id,
            auth()->user()->id
        );
        return new ApiResponse("Get all contracts by payed!!!", true, $contracts);
    }

    public function getAllContractByClientAndUser()
    {
       $contracts =  $this->contractRepository->findByClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt(
           auth()->user()->company_id,
           auth()->user()->company_id,
           auth()->user()->id
       );
//        $contracts = $this->contractRepository->findByClient_Company_IdAndWorker_Company_IdAndWorker_IdOrderByCreatedAt(
//            31,
//            1,
//            4
//        );
        return new ApiResponse("Contract list : ", true, $contracts);
    }

    public function getContractByCompanyId($id)
    {
        //findByWorker_CompanyId
        $contracts = $this->contractRepository->findByWorker_CompanyId($id);
        return new ApiResponse("Contract list : ", true, $contracts);
    }

    public function getAllContractByUserId($id)
    {
        //findByWorkerId
        $contract = $this->contractRepository->findByWorkerId($id);
        return new ApiResponse("Contract list : ", true, $contract);
    }

    public function getContractReportDayByCompany()
    {
        //findByWorker_CompanyAndCreatedAtBetweenAndWorker_CompanyActive

        $id = auth()->user()->company_id;

        $checkComp = $this->checkCompany($id);
//        $checkComp = $this->checkCompany(1);
        if (!$checkComp) {
            return new ApiResponse("Sizdin' kompaniyan`iz bloklang`an!!!", false);
        }

        $start = Carbon::now();
        $start->setHour(0);
        $start->setMinute(0);
        $start->setSecond(1);

        $end = Carbon::now();
        $end->setHour(23);
        $end->setMinute(23);
        $end->setSecond(59);

       $reports =  $this->contractRepository->findByWorker_CompanyAndCreatedAtBetweenAndWorker_CompanyActive(auth()->user()->company_id, $start, $end, true);
//        $reports = $this->contractRepository->findByWorker_CompanyAndCreatedAtBetweenAndWorker_CompanyActive(1, $start, $end, true);

        return new ApiResponse("Menin' kompaniyamnin' ku'nlik contract lar dizimi!", true, $reports);
    }

    public function checkCompany($company_id)
    {
        $company = $this->companyRepository->findById($company_id);
//        return Company::find($company_id)->active;
        return $company->active;
    }

    public function getMyAllContractToNow()
    {
        //findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive
//        $id = auth()->user()->company_id;

//        $checkComp = $this->checkCompany($id);
        $checkComp = $this->checkCompany(1);
        if (!$checkComp) {
            return new ApiResponse("Sizdin' kompaniyan`iz bloklang`an!!!", false);
        }

//        $created_at = auth()->user()->created_at;
        $created_at = Carbon::create(2024, 1, 1);

        $now = Carbon::now();

//        $contracts = $this->contractRepository->findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive(
//            $id,
//            $created_at,
//            $now,
//            true
//        );
        $contracts = $this->contractRepository->findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive(
            1,
            $created_at,
            $now,
            true
        );
        return new ApiResponse("Contract list : ", true, $contracts);
    }

    public function getMyAllContractBeetwen($start, $end)
    {
        $count = 0;
        if ($start == "dan" || $start == "") {
            $count++;
            $created_at = Carbon::create(auth()->user()->created_at->year, auth()->user()->created_at->month, auth()->user()->created_at->day);
        }
        if ($count == 0){
            $created_at = Carbon::create(substr($start, 6, 4), substr($start, 3, 2), substr($start, 0, 2));
        }

        $created_at2 = Carbon::create(substr($end, 6, 4), substr($end, 3, 2), substr($end, 0, 2));

        $created_at->setHour(0);
        $created_at->setMinute(0);
        $created_at->setSecond(1);

        $created_at2->setHour(23);
        $created_at2->setMinute(59);
        $created_at2->setSecond(59);

        //                                      findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive
        $contracts = $this->contractRepository->findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive(
            auth()->user()->id,
            $created_at,
            $created_at2,
            true
        );

        return new ApiResponse("Contract list by beetwen date", true, $contracts);
    }

    public function getContractReportYearByCompany($yearNumber)
    {
        $id = auth()->user()->company_id;

        $checkComp = $this->checkCompany($id);
//        $checkComp = $this->checkCompany(1);
        if (!$checkComp) {
            return new ApiResponse("Sizdin' kompaniyan`iz bloklang`an!!!", false);
        }

        $start = Carbon::create($yearNumber, 1, 1, 0, 0, 1);
        $end = Carbon::create($yearNumber, 12, 31, 23, 59, 59);

        //findByWorker_CompanyAndCreatedAtBetweenAndWorker_CompanyActive

        $yearContracts = $this->contractRepository->findByWorker_CompanyAndCreatedAtBetweenAndWorker_CompanyActive(
            auth()->user()->company_id,
            $start,
            $end,
            true
        );
//        $yearContracts = $this->contractRepository->findByWorker_CompanyAndCreatedAtBetweenAndWorker_CompanyActive(
//            1,
//            $start,
//            $end,
//            true
//        );
        return new ApiResponse("Menin' kompaniyamnin' jilliq(godovoy) contractlar listi : ", true, $yearContracts);
    }

    public function getMyContractReportDay($date)
    {
        $id = auth()->user()->company_id;

        $checkComp = $this->checkCompany($id);
//        $checkComp = $this->checkCompany(1);
        if (!$checkComp) {
            return new ApiResponse("Sizdin' kompaniyan`iz bloklang`an!!!", false);
        }

        $dayStart = Carbon::create(substr($date,6,4), substr($date,3,2), substr($date,0,2), 0,0,1);
        $dayEnd = Carbon::create(substr($date,6,4), substr($date,3,2), substr($date,0,2), 23,59,59);

//        $contracts = $this->contractRepository->findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive(
//            auth()->user()->id,
//            $dayStart,
//            $dayEnd,
//            true
//        );                                    findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive
        $contracts = $this->contractRepository->findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive(
            1,
            $dayStart,
            $dayEnd,
            true
        );
        return new ApiResponse("Ku'nlik esabat : ", true, $contracts);
    }

    public function getMyContractReportYear($yearNumber)
    {
        $id = auth()->user()->company_id;

        $checkComp = $this->checkCompany($id);
//        $checkComp = $this->checkCompany(1);
        if (!$checkComp) {
            return new ApiResponse("Sizdin' kompaniyan`iz bloklang`an!!!", false);
        }

        $yearStart = Carbon::create($yearNumber,1,1,0,0,1);
        $yearEnd = Carbon::create($yearNumber,12,31,23,59,59);

        $contracts = $this->contractRepository->findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive(
            auth()->user()->id,
            $yearStart,
            $yearEnd,
            true
        );
        //findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive
//        $contracts = $this->contractRepository->findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive(
//            1,
//            $yearStart,
//            $yearEnd,
//            true
//        );
        return new ApiResponse("Jilliq report : ", true, $contracts);
    }

    public function getMyContractReportMonth($month, $year)
    {
        $id = auth()->user()->company_id;

        $checkComp = $this->checkCompany($id);
//        $checkComp = $this->checkCompany(1);
        if (!$checkComp) {
            return new ApiResponse("Sizdin' kompaniyan`iz bloklang`an!!!", false);
        }
        $lastDay = Carbon::create($year, $month)->daysInMonth;
        $start = Carbon::create($year, $month, 1, 0,0, 1);
        $end = Carbon::create($year, $month, $lastDay, 23,59, 59);


        $contracts = $this->contractRepository->findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive(
            auth()->user()->id,
            $start,
            $end,
            true
        );
//        findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive
//        $contracts = $this->contractRepository->findByWorkerIdAndCreatedAtBetweenAndWorker_CompanyActive(
//            1,
//            $start,
//            $end,
//            true
//        );
        return new ApiResponse("Ayliq report : ", true, $contracts);
    }


}
