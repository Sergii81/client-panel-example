<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlet');
    }

    public function gateway()
    {
        return $this->belongsTo('App\Models\Gateway');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\User', 'client_id', 'id');
    }
}
