<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartureAndArrivalFish extends Model
{
    use SoftDeletes;
    protected $table = 'departure_arrival_fishs';
    protected $guarded = [];
     protected $dates = ['deleted_at'];


    public function departure()
    {
        return $this->belongsTo(Departureproduct::class, 'departure_id');
    }

    public function arrival()
    {
        return $this->belongsTo(ArrivalProduct::class, 'arrival_id');
    }

    public function departureFish()
    {
        return $this->belongsTo(Fish::class, 'departure_fish_id');
    }

    public function arrivalFish()
    {
        return $this->belongsTo(Fish::class, 'arrival_fish_id');
    }
}
