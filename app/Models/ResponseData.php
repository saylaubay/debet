<?php

namespace App\Models;

class ResponseData
{
    public $part;

    public $allPercentSumma;

    public $monthSumma;

    public $allSumma;

    public $monthPercentSumma;

    public function __construct($part, $allPercentSumma, $monthSumma, $allSumma, $monthPercentSumma)
    {
        $this->part = $part;
        $this->allPercentSumma = $allPercentSumma;
        $this->monthSumma = $monthSumma;
        $this->allSumma = $allSumma;
        $this->monthPercentSumma = $monthPercentSumma;
    }






}
