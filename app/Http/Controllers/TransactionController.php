<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Outlet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Типы платежных карт.
     *
     * @var array
     */
    private $card_types;

    /**
     * PaymentController constructor.
     */
    public function __construct()
    {
        $this->card_types = [
            '1' => 'Amex',
            '2' => 'Visa',
            '3' => 'Mastercard',
            '4' => 'Discover'
        ];
    }

    /**
     * Метод предназначен для обработки АПИ запроса по созданию нового платежа.
     *
     * @param Request $request
     *
     * @return string
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_key' => 'required|min:32|max:32',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'zip' => 'nullable',
            'city' => 'nullable',
            'uid' => 'required|numeric',
            'pid' => 'required|numeric',
            'amount' => 'required|numeric',
            'gateway' => 'required',
            'currency' => 'required|alpha|max:3',
            'ip' => 'nullable|ip',
            'country' => 'nullable',
            'description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $outlet = Outlet::where('api_key', $request->api_key)->first();
        if(empty($outlet)) {
            return response()->json([
                'errors' => 'Wrong Outlet'
            ]);
        }

        $gateway = Gateway::where('name', $request->gateway)->firstOrFail();

        $amount = $request->input('amount')*(1+($gateway->transaction_percent + $gateway->our_percent)/100);
        $transaction = new Transaction;
        $transaction->token = $this->_generateToken();
        $transaction->user_first_name = $request->input('first_name');
        $transaction->user_last_name = $request->input('last_name');
        $transaction->phone = ($request->input('phone')) ? $request->input('phone') : '';
        $transaction->email = ($request->input('email')) ? $request->input('email') : '';
        $transaction->address = ($request->input('address')) ? $request->input('address') : '';
        $transaction->zip = ($request->input('zip')) ? $request->input('zip') : '';
        $transaction->city = ($request->input('city')) ? $request->input('city') : '';
        $transaction->ip = ($request->input('ip')) ? $request->input('ip') : '';
        $transaction->country = ($request->input('location')) ? $request->input('location') : '';
        $transaction->ext_user_id = $request->input('uid');
        $transaction->ext_payment_id = $request->input('pid');
        $transaction->ext_description = $request->input('description');
        $transaction->amount = $amount;
        $transaction->amount_to_balance = $request->input('amount');
        $transaction->currency = $request->input('currency');
        $transaction->signature = base64_encode(
            $request->input('uid')
            .'-'. $request->input('pid')
            .'-'. $amount
            .'-'. $request->input('currency')
        );
        $transaction->client_id = $outlet->client_id;
        $transaction->gateway_id = $gateway->id;
        $transaction->outlet_id = $outlet->id;
        $transaction->status = 'created';
        $transaction->success_url = $outlet->success_url;
        $transaction->callback_url = $outlet->callback_url;
        $transaction->failed_url = $outlet->failed_url;
        $transaction->timestamps = true;
        $transaction->save();


        return redirect()->route('transaction.order.create', ['token' => $transaction->token]);
    }



    /**
     * Вывод транзакций
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if(!empty($request->transaction_from) && !empty($request->transaction_to)) {
            $date_from = date('Y-m-d', strtotime($request->transaction_from));
            $date_to = date('Y-m-d', strtotime($request->transaction_to));
            $transactions = Transaction::where('client_id', auth()->user()->id)
                ->where('created_at', '>=', $request->transaction_from)
                ->where('created_at', '<=', $request->transaction_to)
                ->get();
        } else {
            $date_from = '';
            $date_to = '';
            $transactions = Transaction::where('client_id', auth()->user()->id)->get();
        }

        return view('transactions.index', ['data' => [
            'date_from'     => $date_from,
            'date_to'       => $date_to,
            'transactions'  => $transactions,
            'route'         => $request->route()->getName(),
            'query'         => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
        ]]);
    }

    /**
     * Подробности о транзакции
     * @param Request $request
     * @param $transaction_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDetails(Request $request, $transaction_id)
    {
        $transaction = Transaction::where('id', $transaction_id)->first();
        return view('transactions.show_details', ['data' => [
            'transaction' => $transaction,
            'route' => $request->route()->getName(),
            'query' => is_null($request->getQueryString()) ? '' : '?'. $request->getQueryString(),
        ]]);
    }

    /**
     * Метод гененрирует уникальный токен для идентификации платежа.     *
     * @return string
     */
    private function _generateToken()
    {
        $token = Str::random(32);

        if(0 < Transaction::where('token', $token)->count()) {
            $token = $this->_generateToken();
        }

        return $token;
    }

}
