<?php

namespace App\Models;


class DebetDto
{
//@Column(nullable = false)
//    private String monthName;
//
////    @Column(nullable = false)
////    private String model;
//
//    @Column(nullable = false)
//    private double summa;
//
//    @ManyToOne
//    private Contract contract;
//
//    private boolean paid = false;
//
//    private Timestamp payDate;

    public $month_name;

    public $summa;

    public $contract_id;

    public $paid;

    public $pay_date;


}
