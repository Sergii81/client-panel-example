<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    public function gateway()
    {
        return $this->belongsTo('App\Models\Gateway');
    }
}
