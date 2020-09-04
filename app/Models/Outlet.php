<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    public function gateway1()
    {
        return $this->belongsTo('App\Models\Gateway', 'gateway_1', 'id');
    }

    public function gateway2()
    {
        return $this->belongsTo('App\Models\Gateway', 'gateway_2', 'id');
    }

    public function transaction()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }


}
