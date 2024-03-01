<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

//    protected $guarded = [];

    protected $fillable = [
        "name",
        "model",
        "active",
    ];


    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }



}
