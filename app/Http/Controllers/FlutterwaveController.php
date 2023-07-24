<?php

namespace App\Http\Controllers;

use App\CentralLogics\Helpers;
use App\Models\Order;
use Illuminate\Http\Request;

class FlutterwaveController extends Controller
{
    /**
     * Summary of initialize
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|mixed|string
     */
    public function initialize(Request $request)
    {
        $config = Helpers::get_business_settings('flutterwave');
        $data = Order::with(['customer'])->whereId($request->order_id)->first();
        $business_name = Helpers::get_business_settings('business_name');

        $payer = $data->customer;

        //* Prepare our rave request
        $request = [
            'tx_ref' => time(),
            'amount' => $data->order_amount,
            'currency' => 'NGN',
            'payment_options' => 'card',
            'redirect_url' => route('flutterwave_callback', ['payment_id' => $data->id]),
            'customer' => [
                'email' => $payer->email,
                'name' => $payer->f_name. ' '. $payer->l_name
            ],
            'meta' => [
                'price' => $data->order_amount
            ],
            'customizations' => [
                'title' => $business_name,
                'description' => $data->id
            ]
        ];

        //http request
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($request),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $config['secret_key'],
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response);
        if ($res->status == 'success') {
            return redirect()->away($res->data->link);
        }

        return 'We can not process your payment';
    }

    /**
     * Summary of callback
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function callback(Request $request)
    {
        $config = Helpers::get_business_settings('flutterwave');
        $order = Order::where('id',$request['payment_id'])->first();
        if ($request['status'] == 'successful') {
            $txid = $request['transaction_id'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txid}/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $config['secret_key'],
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            
            $res = json_decode($response);
            if ($res->status) {
                $amountPaid = $res->data->charged_amount;
                $amountToPay = $res->data->meta->price;
                if ($amountPaid >= $amountToPay) {
                    try {
                        $order->transaction_reference = $txid;
                        $order->payment_method = 'flutterwave';
                        $order->payment_status = 'paid';
                        $order->order_status = 'confirmed';
                        $order->confirmed = now();
                        $order->save();
                        Helpers::send_order_notification($order);
                    } catch (\Exception $e) {
                    }
        
                    if ($order->callback != null) {
                        return redirect($order->callback . '&status=success');
                    }else{
                        return \redirect()->route('payment-success');
                    }
                }
            }
        }
        $order->order_status = 'failed';
        $order->failed = now();
        $order->save();
        if ($order->callback != null) {
            return redirect($order->callback . '&status=fail');
        }else{
            return \redirect()->route('payment-fail');
        }
    }

}
