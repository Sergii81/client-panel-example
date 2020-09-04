<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Gateway;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OutletController extends Controller
{
    /**
     * Вывод магазинов клиента
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $outlets = Outlet::all();
        return view('outlets.index', ['data' => [
            'outlets'   => $outlets,
            'route'     => $request->route()->getName(),
            'query'     => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
        ]]);
    }

    /**
     * Форма для создания нового магазина
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddForm(Request $request)
    {
        $gateways = Gateway::all();
        return view('outlets.show_add_form', ['data' => [
            'gateways'  => $gateways,
            'route'     => $request->route()->getName(),
            'query'     => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
        ]]);
    }

    /**
     * Создание нового магазина
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'outlet_url' => 'required|active_url|unique:outlets',
            'success_url' => 'required|active_url',
            'failed_url' => 'required|active_url',
            'callback_url' => 'required|active_url',
        ],
        [
            'outlet_url.active_url'     => __('outlets.outlet_validator.outlet_url'),
            'success_url.active_url'    => __('outlets.outlet_validator.success_url'),
            'failed_url.active_url'     => __('outlets.outlet_validator.failed_url'),
            'callback_url.active_url'   => __('outlets.outlet_validator.callback_url'),
            'outlet_url.unique'         => __('outlets.outlet_validator.unique_url'),
        ]);

        $outlet = new Outlet;
        $outlet->name = $request->name;
        $outlet->client_id = $request->client_id;
        $outlet->outlet_url = $request->outlet_url;
        if(!empty($request->gateway_1)) {
            $outlet->gateway_1 = $request->gateway_id_1;
        }
        if(!empty($request->gateway_2)) {
            $outlet->gateway_2 = $request->gateway_id_2;
        }
        $outlet->outlet_status = $request->outlet_status;
        $outlet->success_url = $request->success_url;
        $outlet->failed_url = $request->failed_url;
        $outlet->callback_url = $request->callback_url;
        $outlet->api_key = $this->generate_key();
        $outlet->secret_key = $this->generate_key();
        $outlet->save();
        //создание баланса отдельно по шлюзам при создании магазина,
        if($outlet) {
            if(!empty($outlet->gateway_1)) {
                $this->makeBalance($outlet, $outlet->gateway_1);
            }
            if(!empty($outlet->gateway_2)) {
                $this->makeBalance($outlet, $outlet->gateway_2);
            }
        }
        return redirect()->route('payment_system:outlets.index');
    }

    /**
     * Форма для редактирования магазина
     * @param Request $request
     * @param $outlet_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditForm(Request $request, $outlet_id)
    {
        $outlet = Outlet::where('id', $outlet_id)->first();
        $gateways = Gateway::all();
        return view('outlets.show_edit_form', ['data' => [
            'outlet'    => $outlet,
            'gateways'  => $gateways,
            'route'     => $request->route()->getName(),
            'query'     => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
        ]]);
    }

    /**
     * Редактирование магазина
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'outlet_url' => 'required|active_url',
            'success_url' => 'required|active_url',
            'failed_url' => 'required|active_url',
            'callback_url' => 'required|active_url',
        ],
        [
            'outlet_url.active_url'     => __('outlets.outlet_validator.outlet_url'),
            'success_url.active_url'    => __('outlets.outlet_validator.success_url'),
            'failed_url.active_url'     => __('outlets.outlet_validator.failed_url'),
            'callback_url.active_url'   => __('outlets.outlet_validator.callback_url'),
            'outlet_url.unique'         => __('outlets.outlet_validator.unique_url'),
        ]);

        $outlet = Outlet::where('id', $request->outlet_id)->first();
        $outlet->name = $request->name;
        $outlet->outlet_url = $request->outlet_url;
        if(!empty($request->gateway_1)) {
            $outlet->gateway_1 = $request->gateway_id_1;
        } else {
            $outlet->gateway_1 = null;
        }
        if(!empty($request->gateway_2)) {
            $outlet->gateway_2 = $request->gateway_id_2;
        } else {
            $outlet->gateway_2 = null;
        }
        $outlet->outlet_status = $request->outlet_status;
        $outlet->success_url = $request->success_url;
        $outlet->failed_url = $request->failed_url;
        $outlet->callback_url = $request->callback_url;
        $outlet->save();

        //создание/удаление баланса при смене шлюза
        if($outlet) {
            if(!empty($outlet->gateway_1)) {
                $this->makeBalance($outlet, $outlet->gateway_1);
            } else {
                $this->deleteBalance($outlet, $outlet->gateway_1);
            }
            if(!empty($outlet->gateway_2)) {
                $this->makeBalance($outlet, $outlet->gateway_2);
            } else {
                $this->deleteBalance($outlet, $outlet->gateway_1);
            }
        }
        return redirect()->route('payment_system:outlets.index');
    }

    /**
     * Удаление магазина
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        Outlet::where('id', $request->outlet_id)->delete();
        return redirect()->route('payment_system:outlets.index');
    }

    /**
     * Генерация апи и секретного ключей
     * @return string
     */
    private function generate_key()
    {
        return Str::random(32);
    }

    /**
     * Создание баланса
     * @param $outlet
     * @param $gateway_id
     */
    public function makeBalance($outlet, $gateway_id)
    {
        $balance = Balance::where('client_id', $outlet->client_id)
                            ->where('gateway_id', $gateway_id)
                            ->first();
        if(empty($balance)) {
            $balance = new Balance;
            $balance->client_id = $outlet->client_id;
            $balance->gateway_id = $gateway_id;
            $balance->sum = 0;
            $balance->currency = ($gateway_id == 1) ? $outlet->gateway1()->first()->currency : $outlet->gateway2()->first()->currency;
            $balance->rolling_reserve = 0;
            $balance->rolling_reserve_to_payout = 0;
            $balance->available_for_payout = 0;
            $balance->save();
        }

    }

    /**
     * Удаление баланса при смене шлюза
     * @param $outlet
     * @param $gateway_id
     */
    public function deleteBalance($outlet, $gateway_id)
    {
        $balance = Balance::where('client_id', $outlet->client_id)
                            ->where('gateway_id', $gateway_id)
                            ->first();
        if(!empty($balance)) {
            $balance->delete();
        }
    }



}
