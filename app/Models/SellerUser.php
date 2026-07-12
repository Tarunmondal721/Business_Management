<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerUser extends Model
{
    protected $table = 'seller_users';
    protected $guarded = [];


    public function ScopeGetBystatus($query)
    {
        return $query->where('status', 1);
    }
}
