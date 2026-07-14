<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departureproduct extends Model
{
    use SoftDeletes;
    protected $table = 'departureproducts';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function seller()
    {
        return $this->belongsTo(SellerUser::class, 'seller_id');
    }

    public function arrival()
    {
        return $this->hasOne(ArrivalProduct::class, 'departure_id');
    }

    public function fishes()
    {
        return $this->hasMany(DepartureAndArrivalFish::class, 'departure_id');
    }

    public function billfish()
    {
        return $this->hasMany(DepartureAndArrivalFish::class, 'arrival_id');
    }
}
