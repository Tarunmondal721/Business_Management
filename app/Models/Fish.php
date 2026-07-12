<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    protected $guarded = [];
    protected $table = 'fishs';


    public function ScopeGetBystatus($query)
    {
        return $query->where('status', 1);
    }

}
