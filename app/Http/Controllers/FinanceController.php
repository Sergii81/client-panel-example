<?php

namespace App\Http\Controllers;

use App\Mail\AdminNotifications;
use App\Models\Balance;
use App\Models\Gateway;
use App\Models\Hold;
use App\Models\Location;
use App\Models\Outlet;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FinanceController extends Controller
{
    /**
     * Вывод баланса клиента по каждому шлюзу
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBalance(Request $request)
    {
        //сумма баланса по клиенту-пользователю группированная по шлюзам
        $balances_gateway_sum = Balance::where('client_id', auth()->user()->id)
                                            ->select('gateway_id', 'currency', 'rolling_reserve', DB::raw('SUM(sum) as gateway_sum'), DB::raw('SUM(rolling_reserve) as gateway_rolling_reserve'))
                                            ->groupBy('gateway_id')
                                            ->get();

        //баланс клиента по шлюзу_1 (Platio)
        $balances_gateway_1 = Balance::where('client_id', auth()->user()->id)
                                        ->where('gateway_id', 1)
                                        ->get();

        //баланс клиента по шлюзу_2 (Neobanq)
        $balances_gateway_2 = Balance::where('client_id', auth()->user()->id)
                                        ->where('gateway_id', 2)
                                        ->get();

        //Hold клиента по шлюзу_1 (Platio)
        $holds_gateway_1 = Hold::where('client_id', auth()->user()->id)
                            ->where('gateway_id', 1)
                            ->get();

        //Hold клиента по шлюзу_2 (Neobanq)
        $holds_gateway_2 = Hold::where('client_id', auth()->user()->id)
                            ->where('gateway_id', 2)
                            ->get();

        return view('finance.show_balance', ['data' => [
            'balances_gateway_sum'  => $balances_gateway_sum,
            'balances_gateway_1'    => $balances_gateway_1,
            'balances_gateway_2'    => $balances_gateway_2,
            'holds_gateway_1'       => $holds_gateway_1,
            'holds_gateway_2'       => $holds_gateway_2,
            'route'     => $request->route()->getName(),
            'query'     => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
        ]]);
    }

    /**
     * Выплаты клиента
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payouts(Request $request)
    {
        $payouts = Payout::where('client_id', auth()->user()->id)->get();

        return view('finance.payouts', ['data' => [
            'payouts'   => $payouts,
            'route' => $request->route()->getName(),
            'query' => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
        ]]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payoutsCreateForm(Request $request)
    {
        $gateway_1 = Gateway::where('id', auth()->user()->gateway_1)->first();
        $gateway_2 = Gateway::where('id', auth()->user()->gateway_2)->first();
        return view('finance.payouts_create_form', ['data' => [
            'gateway_1' => $gateway_1,
            'gateway_2' => $gateway_2,
            'route'     => $request->route()->getName(),
            'query'     => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
        ]]);
    }

    /**
     * Вывод формы для запроса выплаты в зависимости от шлюза
     * @param Request $request
     * @param $gateway_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function  payoutsCreateFormGatewayName(Request $request, $gateway_id)
    {
        if($gateway_id == 1) {
            $gateway = Gateway::where('id', $gateway_id)->first();
            $amount = Balance::where('client_id', auth()->user()->id)
                                    ->where('gateway_id', $gateway_id)
                                    ->select('currency', DB::raw('available_for_payout - payout_amount as amount'))
                                    ->first();
            return view('finance.payouts_create_form_platio', ['data' => [
                'gateway'   => $gateway,
                'amount'    => $amount,
                'route'     => $request->route()->getName(),
                'query'     => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
            ]]);
        }

        if($gateway_id == 2) {
            $gateway = Gateway::where('id', $gateway_id)->first();
            $amount = Balance::where('client_id', auth()->user()->id)
                            ->where('gateway_id', $gateway_id)
                            ->select('currency', DB::raw('available_for_payout - payout_amount as amount'))
                            ->first();
            $locations = Location::all();
            return view('finance.payouts_create_form_neobanq', ['data' => [
                'locations' => $locations,
                'gateway'   => $gateway,
                'amount'    => $amount,
                'route'     => $request->route()->getName(),
                'query'     => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
            ]]);
        }

    }

    /**
     * Создание выплаты в зависимости от шлюза
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payoutsCreate(Request $request)
    {
        //var_dump($request->all()); exit;

        $payout = new Payout;
        $payout->client_id = $request->client_id;

        if($request->gateway_id == 1) {
            $request->validate(
                [
                    'amount'        => 'required',
                    'card_no'   => 'required|min:16|max:16',
                ],
                [
                    'amount.required'   => __('payouts_create.validator.amount_1_require'),
                    'card_no.required'  => __('payouts_create.validator.card_no_require'),
                    'card_no.min'       => __('payouts_create.validator.card_no_min'),
                    'card_no.max'       => __('payouts_create.validator.card_no_max'),
                ]
            );

            $payout->gateway_id = $request->gateway_id;
            $payout->amount = $request->amount;
            $payout->currency = $request->gateway_currency;
            $payout->payout_method = $request->gateway_payment_method;
            $payout->card_no = $request->card_no;
            $this->payoutToBalance($payout->client_id, $request->gateway_id, $request->amount);
        }

        if($request->gateway_id == 2) {
            $request->validate(
                [
                    'amount'        => 'required',
                    'iban'          => 'required',
                    'beneficiary'   => 'required',
                    'country'       => 'required',
                    'city'          => 'required',
                    'address'       => 'required',
                    'bank_name'     => 'required',
                    'swift'         => 'required',
                ],
                [
                    'amount.required'       => __('payouts_create.validator.amount_2_require'),
                    'iban.required'         => __('payouts_create.validator.iban_require'),
                    'beneficiary.required'  => __('payouts_create.validator.beneficiary_required'),
                    'country.required'      => __('payouts_create.validator.country_required'),
                    'city.required'         => __('payouts_create.validator.city_required'),
                    'address.required'      => __('payouts_create.validator.address_required'),
                    'bank_name.required'    => __('payouts_create.validator.bank_name_required'),
                    'swift.required'        => __('payouts_create.validator.swift_required'),
                ]
            );


            $payout->gateway_id = $request->gateway_id;
            $payout->amount = $request->amount;
            $payout->currency = $request->gateway_currency;
            $payout->payout_method = $request->gateway_payment_method;
            $payout->iban = $request->iban;
            $payout->beneficiar = $request->beneficiary;
            $payout->country = $request->country;
            $payout->city = $request->city;
            $payout->address = $request->address;
            $payout->bank_name = $request->bank_name;
            $payout->swift = $request->swift;
            $this->payoutToBalance($payout->client_id, $request->gateway_id, $request->amount);
        }

        // рассылка емейла админ юзерам о создании запроса на выплату
        $admin_users = DB::table('users')->where('do_mailing', 1)->get();

        foreach($admin_users as $admin_user) {
            $notification = new \stdClass();
            $notification->subject = __('payouts.mail.subject_1');
            $notification->body = __('payouts.mail.body_1');
            //var_dump($notification); echo "<hr>";
            Mail::to($admin_user->email)->send(new AdminNotifications($notification)); // рассылка емейла админ юзерам о создании запроса на выплату
        }
        //конец рассылки

        $payout->status = 'created';
        $payout->save();



        return redirect()->route('payment_system:finance.payouts');

    }

    /**
     * Метод для корректировки баланса при создании выплаты (уменьшает сумму доступную к выводу на величину выплаты)
     * @param $client_id
     * @param $gateway_id
     * @param $payout_amount
     */
    public function payoutToBalance($client_id, $gateway_id, $payout_amount)
    {
        $balance = Balance::where('client_id', $client_id)
                            ->where('gateway_id', $gateway_id)
                            ->first();
        $balance->payout_amount = $payout_amount;
        $balance->save();
    }


}
