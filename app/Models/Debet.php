<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debet extends Model
{
    use HasFactory;

//    protected $guarded = [];

    protected $fillable = [
        "month_name",
        "summa",
        "contract_id",
        "paid",
        "pay_date",
        "active",
        "desc",
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }


}
