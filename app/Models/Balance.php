<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Balance extends Model
{
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function gateway()
    {
        return $this->belongsTo('App\Models\Gateway');
    }



    // Баланс по шлюзам для вывода в шапке
    public static function getBalance()
    {
        return Balance::where('client_id', auth()->user()->id)
                            ->select('gateway_id', 'currency', DB::raw('available_for_payout - payout_amount  as amount'))
                            ->groupBy('gateway_id')
                            ->get();
    }
}
