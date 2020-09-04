<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction');
    }

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlet');
    }

    public function gateway()
    {
        return $this->belongsTo('App\Models\Gateway');
    }
}
