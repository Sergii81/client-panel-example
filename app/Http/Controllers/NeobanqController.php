<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Hold;
use App\Models\Location;
use App\Models\Transaction;
use App\NeobanqGateway;
use App\TestGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NeobanqController extends Controller
{

    /**
     * Метод предназначен для построения формы создания платежа.
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($token)
    {
        $transaction = Transaction::where('token', $token)->firstOrFail();
        $locations = Location::all();

        return view('neobanq.form', [
            'action'    => route('transaction.order.processing', ['token' => $transaction->token]),
            'transaction'=> $transaction,
            'locations' => $locations,
        ]);

    }

    /**
     * Метод предназначен для обработки сабмита платежной формы и запуска обработки платежа платежным шлюзом.
     * @param $token
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function processing($token, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signature' => 'required|string|exists:transactions,signature',
            'amount' => 'required|numeric',
            'currency' => 'required|alpha|max:3',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string',
            'country' => 'required|string|exists:locations,iso_3166_1_alpha2',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'email' => 'required|email|max:255',
            'phone_no' => 'required|string',
            'card_type' => 'required',
            'card_no' => 'required|min:16|max:16',
            'ccExpiryMonth' => 'required|min:2|max:2',
            'ccExpiryYear' => 'required|min:4|max:4',
            'cvvNumber' => 'required|string|min:3|max:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $transaction = Transaction::where('token', $token)->firstOrFail();

        $signature = base64_encode(
            $transaction->ext_user_id
            .'-'. $transaction->ext_payment_id
            .'-'. $request->input('amount')
            .'-'. $request->input('currency')
        );

        if($signature !== $transaction->signature
            || $request->input('signature') != $transaction->signature) {
            // ошибка подписи
            $transaction->status = 'failed';
            $transaction->save();

            $transaction_answer = [
                'status' => 'fail',
                'token' => $transaction->token,
                'pid' => $transaction->ext_payment_id,
                'uid' => $transaction->ext_user_id,
                'message' => 'Payment signature is incorrect',
            ];

            return $this->_handleProcessingResult((object)$transaction_answer, $transaction);
        }

        $transaction->user_first_name = $request->input('first_name');
        $transaction->user_last_name = $request->input('last_name');
        $transaction->ip = $request->ip();
        $transaction->address = $request->input('address');
        $transaction->country = $request->input('country');
        $transaction->state = $request->input('state');
        $transaction->city = $request->input('city');
        $transaction->zip = $request->input('zip');
        $transaction->email = $request->input('email');
        $transaction->phone = $request->input('phone_no');
        $transaction->card_type = $request->input('card_type');
        $transaction->card_no = $request->input('card_no');
        $transaction->card_month = $request->input('ccExpiryMonth');
        $transaction->card_year = $request->input('ccExpiryYear');
        $transaction->card_cvv = $request->input('cvvNumber');
        $transaction->status = 'processing';
        $transaction->timestamps = true;
        $transaction->save();


        $outlet = $transaction->outlet()->first();

        if($outlet->outlet_status == 'test') {
            $transaction_answer = (new TestGateway())->processing($transaction);
            return redirect($transaction_answer);
        }


        $transaction_answer = (new TestGateway())->success();
        //$transaction_answer = (new NeobanqGateway())->processing($transaction);


        return $this->_handleProcessingResult($transaction_answer, $transaction);
    }

    /**
     * Метод обрабатывает результаты транзакции
     * записывает изменения баланса, холда
     * и формирует ссылку для редиректа пользователя.
     *
     * @param $transaction_answer
     * @param $transaction
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function _handleProcessingResult($transaction_answer, $transaction)
    {
        switch ($transaction_answer->status) {
            case 'success':
                // сохраняем актуальную информацию о платеже
                if(isset($transaction_answer->message)){
                    $transaction->gateway_message = $transaction_answer->message;
                }
                $transaction->gateway_status = $transaction_answer->status;
                $transaction->gateway_order_id = $transaction_answer->order_id;
                $transaction->status = 'completed';
                $transaction->timestamps = true;
                $transaction->save();
                //to Balance
                $gateway = $transaction->gateway()->first();
                $balance = Balance::where('client_id', $transaction->client_id)
                    ->where('gateway_id', $transaction->gateway_id)
                    ->firstOrFail();
                $balance->sum += $transaction->amount_to_balance;
                $balance->rolling_reserve += $transaction->amount_to_balance*($gateway->rolling/100);
                $balance->available_for_payout += $transaction->amount_to_balance - $transaction->amount_to_balance*($gateway->rolling/100);
                $balance->timestamps = true;
                $balance->save();

                //to Hold
                $hold = new Hold;
                $hold->transaction_id = $transaction->id;
                $hold->transaction_amount = $transaction->amount_to_balance;
                $hold->outlet_id = $transaction->outlet_id;
                $hold->gateway_id = $transaction->gateway_id;
                $hold->hold_count = $gateway->hold;
                $hold->hold = $gateway->hold;
                $hold->rolling_reserve = $transaction->amount_to_balance*($gateway->rolling/100);
                $hold->client_id = $transaction->client_id;
                $hold->save();
                // формируем ссылку для редиректа
                $redirect = $transaction->success_url .'?'. http_build_query([
                        'status' => 'success',
                        'token' => $transaction->token,
                        'pid' => $transaction->ext_payment_id,
                        'uid' => $transaction->ext_user_id,
                        'order_id' => isset($transaction_answer->order_id) ? $transaction_answer->order_id : null,
                        'message' => isset($transaction_answer->message) ? $transaction_answer->message : '',
                    ]);
                break;
            case 'pending':
                // сохраняем актуальную информацию о платеже
                if(isset($transaction_answer->message)){
                    $transaction->gateway_message = $transaction_answer->message;
                }
                $transaction->gateway_status = $transaction_answer->status;
                $transaction->gateway_order_id = $transaction_answer->order_id;
                $transaction->status = 'pending';
                $transaction->timestamps = true;
                $transaction->save();
                // формируем ссылку для редиректа
                $redirect = $transaction->success_url .'?'. http_build_query([
                        'status' => 'pending',
                        'token' => $transaction->token,
                        'pid' => $transaction->ext_payment_id,
                        'uid' => $transaction->ext_user_id,
                        'order_id' => isset($transaction_answer->order_id) ? $transaction_answer->order_id : null,
                        'message' => isset($transaction_answer->message) ? $transaction_answer->message : '',
                    ]);
                // проверить статус платежа через 10 минут
                //dispatch((new UpdatePaymentStatus($transaction))->onQueue('statuses'));
                break;
            case '3d_redirect':
                // сохраняем актуальную информацию о платеже
                $transaction->gateway_message = $transaction_answer->redirect_3ds_url;
                $transaction->gateway_status = $transaction_answer->status;
                $transaction->timestamps = true;
                $transaction->save();
                // формируем ссылку для редиректа
                $redirect = $transaction_answer->redirect_3ds_url;
                break;
            case 'fail':
            default:
                // сохраняем актуальную информацию о платеже
                if(isset($transaction_answer->message)){
                    $transaction->gateway_message = $transaction_answer->message;
                }
                $transaction->gateway_status = $transaction_answer->status;
                $transaction->status = 'fail';
                $transaction->timestamps = true;
                $transaction->save();
                // формируем ссылку для редиректа
                $redirect = $transaction->failed_url .'?'. http_build_query([
                        'status' => 'fail',
                        'token' => $transaction->token,
                        'pid' => $transaction->ext_payment_id,
                        'uid' => $transaction->ext_user_id,
                        'order_id' => isset($transaction_answer->order_id) ? $transaction_answer->order_id : null,
                        'message' => isset($transaction_answer->message) ? $transaction_answer->message : null,
                    ]);
                break;
        }
        return redirect($redirect);
    }

    /**
     * Согласно документации https://portal.neobanq.app/user-api
     * RESPONSE AFTER 3DS RESPONSE
     * After 3D secure complete, user will be redirect to merchant website.
     * If transaction will be success, user will redirect to ”response_url” (указывается в NeobanqGateway.php)
     * @param Request $request
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function response_url(Request $request, $token)
    {
//        var_dump($request->status);
//        var_dump($token);
//        exit;
        $transaction = Transaction::where('token', $token)->first();
        $transaction_answer = [
            'status'    => $request->status,
            'order_id'  => $request->order_id,
            'message'   => $request->message,
            'token'     => $transaction->token,
            'pid'       => $transaction->ext_payment_id,
            'uid'       => $transaction->ext_user_id,
        ];

        return $this->_handleProcessingResult((object)$transaction_answer, $transaction);

    }

    /**
     * Согласно документации https://portal.neobanq.app/user-api
     * Webhooks events are that sends notifications of transaction to merchant server.
     * If you want to receive webhooks, then send "webhook_url" parameter with initial request (указывается в NeobanqGateway.php)
     * @param Request $request
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback_url(Request $request, $token)
    {
//        var_dump($request->all());
//        var_dump($token);
//        exit;
        $transaction = Transaction::where('token', $token)->first();

        $redirect = $transaction->callback_url .'?'. http_build_query([
                'gateway_order_id'  => $request->order_id,
                'status'    => $request->transaction_status,
                'message'   => $request->reason,
                'amount'    => $request->amount,
                'currency'  => $request->currency,
                'email' => $request->email,
                'test'  => $request->test,
                'transaction_date'  => $request->transaction_date
            ]);
        return redirect($redirect);
    }
}
