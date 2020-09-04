<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'middleware'    => ['api'],
    'domain'        => config('payment_system.app.url'),
], function() {
    Route::post('/transaction/create', 'TransactionController@create');

    Route::prefix('neobanq')->group(function () {
        $namespace = config('payment_system.namespace.neobanq').':';
        Route::post('/response_url/{token}', 'NeobanqController@response_url')->name($namespace.'response_url');
        Route::post('/callback_url/{token}', 'NeobanqController@callback_url')->name($namespace.'callback_url');
    });

    Route::prefix('platio')->group(function () {
        $namespace = config('payment_system.namespace.platio').':';
        Route::post('/success_url/{token}', 'PlatioController@success_url')->name($namespace.'success_url');
        Route::post('/failed_url/{token}', 'PlatioController@failed_url')->name($namespace.'failed_url');
        Route::post('/result_url/{token}', 'PlatioController@result_url')->name($namespace.'result_url');
    });




});
