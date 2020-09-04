<?php


namespace App;


class TestGateway
{
    public function processing($transaction)
    {
        $transaction->status = 'completed_test';
        $transaction->timestamps = true;
        $transaction->save();
        $redirect = $transaction->success_url .'?'. http_build_query([
                'status' => 'success_test',
                'token' => $transaction->token,
                'pid' => $transaction->ext_payment_id,
                'uid' => $transaction->ext_user_id,
            ]);

        return $redirect;
    }

    public function success()
    {
        $transaction_answer = (object)[
            'status' => 'success',
            'message'   => 'success transaction',
            'order_id'  => 1
        ];
        //var_dump(($transaction_answer->status)); exit;
        return $transaction_answer;
    }

    public function fail()
    {
        $transaction_answer = [
            'status' => 'fail',
            'message'   => 'fail transaction',
        ];

        return $transaction_answer;
    }
}
