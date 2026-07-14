<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArrivalProduct extends Model
{
    use SoftDeletes;
    protected $table = 'arrivalproducts';
    protected $guarded = [];

    protected $dates = ['deleted_at'];
    public function departure()
    {
        return $this->belongsTo(Departureproduct::class, 'departure_id');
    }
    public function fishes()
    {
        return $this->belongsTo(Fish::class, 'arrival_fish_id');
    }
}
