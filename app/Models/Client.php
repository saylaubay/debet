<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

//    protected $guarded = [];

    protected $fillable = [
        "first_name",
        "last_name",
        "phone",
        "company_id",
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }





}
