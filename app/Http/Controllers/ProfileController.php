<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gateway;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Вывод информации о клиенте
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $gateways = Gateway::all();
        $locations = Location::all();
        return view('profile.index', ['data' => [
            'locations' => $locations,
            'user'      => $user,
            'gateways'  => $gateways,
            'route'     => $request->route()->getName(),
            'query'     => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
        ]]);
    }

    /**
     * Редактирование данных клиента
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        if(!empty($request->gateway_1)) {
            $user->gateway_1 = $request->gateway_id_1;
        } else {
            $user->gateway_1 = null;
        }
        if(!empty($request->gateway_2)) {
            $user->gateway_2 = $request->gateway_id_2;
        } else {
            $user->gateway_2 = null;
        }
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zip = $request->zip;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('payment_system:profile.index');
    }
}
