<?php

namespace App\Jobs;

use App\Models\Balance;
use App\Models\Gateway;
use App\Models\Hold;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HoldsCountdown implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Обратный отсчет времени холдов
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $holds = Hold::all();
        $now = Carbon::now();
        foreach ($holds as $hold) {
            //если не прошло время холда, уменьшаем количество дней холда
            if($hold->created_at->diffInDays($now) <= $hold->hold) {
                $hold->hold_count -= 1;
                $hold->save();
            } else { // после того как время холда прошло
                $balance = Balance::where('client_id', $hold->client_id)
                                    ->where('gateway_id', $hold->gateway_id)
                                    ->first();
                $balance->available_for_payout += $hold->rolling_reserve;           //пополняем баланс->доступно_к_снятию на сумму роллинга
                $balance->rolling_reserve -= $hold->rolling_reserve;                // баланс->роллинг_резерв уменьшаем на сумму роллинга
                $balance->rolling_reserve_to_payout += $hold->rolling_reserve;      // баланс->роллинг_резерв_к_выплате увеличиваем на сумму роллинга
                $balance->save();
                $hold->rolling_reserve = 0;
                $hold->hold_count = 0;
                $hold->save();
            }
        }
        Hold::where('hold_count', '<=', 0)->delete();

    }
}
