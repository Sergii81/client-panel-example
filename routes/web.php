<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//Auth::routes();



Route::group([
    'middleware'    => ['web'],
    'domain'        => config('payment_system.app.url'),
], function() {

    Route::get('/', function () {
        return view('welcome');
    })->name('payment_system:main');

    Auth::routes(['verify' => true]);

    Route::get('logout', 'Auth\LoginController@logout', function () {
        return abort(404); });

    //Route::post('transaction/processing', 'TransactionController@processing')->name('payment_system:transaction.processing');

    Route::get('create/{token}', function ($token) {
        $transaction = App\Models\Transaction::where('token', $token)->firstOrFail();
        $controller = 'App\\Http\\Controllers\\'. ucfirst($transaction->gateway->name) .'Controller';
        return (new $controller())->create($token);
    })->name('transaction.order.create');

    Route::post('processing/{token}', function ($token, Request $request) {
        $transaction = App\Models\Transaction::where('token', $token)->firstOrFail();
        $controller = 'App\\Http\\Controllers\\'. ucfirst($transaction->gateway->name) .'Controller';
        return (new $controller())->processing($token, $request);
    })->name('transaction.order.processing');

    Route::any('order/{token}/callback', function ($token, Request $request) {
        $transaction = App\Models\Transaction::where('token', $token)->firstOrFail();
        $controller = 'App\\Http\\Controllers\\'. ucfirst($transaction->gateway->name) .'Controller';
        return (new $controller())->callback($token, $request);
    })->name('transaction.gateway.callback');







});

Route::group([
    'middleware'    => ['web', 'auth', 'verified'],
    'domain'        => config('payment_system.app.url'),
], function() {
    /*Profile*/
    Route::get('/profile', 'ProfileController@index')->name('payment_system:profile.index');
    Route::post('/profile/edit', 'ProfileController@edit')->name('payment_system:profile.edit');
    /*Outlets*/
    Route::get('/outlets', 'OutletController@index')->name('payment_system:outlets.index');
    Route::get('/outlets/add_form', 'OutletController@showAddForm')->name('payment_system:outlets.show_add_form');
    Route::post('/outlets/add', 'OutletController@add')->name('payment_system:outlets.add');
    Route::get('/outlets/edit_form/{outlet_id}', 'OutletController@showEditForm')->name('payment_system:outlets.show_edit_form');
    Route::post('/outlets/edit', 'OutletController@edit')->name('payment_system:outlets.edit');
    Route::get('/outlets/delete', 'OutletController@delete')->name('payment_system:outlets.delete');
    /*Transaction*/
    Route::get('/transactions', 'TransactionController@index')->name('payment_system:transactions.index');
    Route::get('/transactions/details/{transaction_id}', 'TransactionController@showDetails')->name('payment_system:transactions.show_details');
    /*Finance*/
    Route::get('/finance/payouts', 'FinanceController@payouts')->name('payment_system:finance.payouts');
    Route::get('/finance/payouts_create_form', 'FinanceController@payoutsCreateForm')->name('payment_system:finance.payouts_create_form');
    Route::get('/finance/payouts_create_form/{gateway_id}', 'FinanceController@payoutsCreateFormGatewayName')->name('payment_system:finance.payouts_create_form_gateway_name');
    Route::post('/finance/payouts_create', 'FinanceController@payoutsCreate')->name('payment_system:finance.payouts_create');
    Route::get('/finance/balance', 'FinanceController@showBalance')->name('payment_system:finance.show_balance');
});


