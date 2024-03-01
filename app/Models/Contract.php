<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

//    protected $guarded = [];

    protected $fillable = [
        "product_id",
        "product_name",
        "user_id",
        "price",
        "client_id",
        "percent",
        "part",
        "active",
    ];


    public function debets()
    {
        return $this->hasMany(Debet::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


}
