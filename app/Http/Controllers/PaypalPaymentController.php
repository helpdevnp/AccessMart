<?php

namespace App\Http\Controllers;

use App\CentralLogics\Helpers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class PaypalPaymentController extends Controller
{
    /**
     * Summary of token
     * @param mixed $config
     * @param mixed $base_url
     * @return bool|string
     */
    public function token($config, $base_url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $base_url.'/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_USERPWD, $config['paypal_client_id'] . ':' . $config['paypal_secret']);

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $accessToken = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $accessToken;
    }

    /**
     * Summary of payment
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function payment(Request $request)
    {
        $config = Helpers::get_business_settings('paypal');
        if($config){
            $base_url = ($config['mode'] == 'test') ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com';
        }

        $business_name = Helpers::get_business_settings('business_name');
        $accessToken = json_decode($this->token($config,$base_url),true);
        $order = Order::whereId($request->order_id)->first();

        if ( isset($accessToken['access_token'])) {
            $accessToken = $accessToken['access_token'];
            $payment_data = [];
            $payment_data['purchase_units'] = [
                [
                    'reference_id' => $order->id,
                    'name' => $business_name,
                    'desc'  => 'payment ID :' . $order->id,
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' =>  number_format($order->order_amount, 2, ".", "")
                    ]
                ]
            ];

            $payment_data['invoice_id'] = $order->id;
            $payment_data['invoice_description'] = "Order #{$payment_data['invoice_id']} Invoice";
            $payment_data['total'] =  number_format($order->order_amount, 2, ".", "");
            $payment_data['intent'] = 'CAPTURE';
            $payment_data['application_context'] = [
                'return_url' => route('paypal.callback',['payment_id' => $order->id]),
                'cancel_url' => route('paypal.cancel',['payment_id' => $order->id])
            ];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $base_url.'/v2/checkout/orders');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($payment_data));

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = "Authorization: Bearer $accessToken";
            $headers[] = "Paypal-Request-Id:".Str::uuid();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
        }else{
            return response()->json([
                'message' => 'information not found'
            ], 200);
        }
;   
        $response = json_decode($response, true);
        $links = $response['links'];
        return Redirect::away($links[1]['href']);
    }
    
    /**
     * Summary of callback
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function callback(Request $request)
    {
        $config = Helpers::get_business_settings('paypal');
        if($config){
            $base_url = ($config['mode'] == 'test') ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com';
        }

        $accessToken = json_decode($this->token($config,$base_url),true);
        $accessToken = $accessToken['access_token'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $base_url."/v2/checkout/orders/{$request->token}/capture");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = "Authorization: Bearer  $accessToken";
        $headers[] = 'Paypal-Request-Id:'.Str::uuid();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $response = json_decode($result);

        $order = Order::where('id',$request['payment_id'])->first();
        if($response->status === 'COMPLETED'){
            $order->transaction_reference = $request['payment_id'];
            $order->payment_method = 'paypal';
            $order->payment_status = 'paid';
            $order->order_status = 'confirmed';
            $order->confirmed = now();
            $order->save();
            try {
                Helpers::send_order_notification($order);
            } catch (\Exception $e) {
                info(['paypal_issue' => $e->getMessage()]);
            }

            if ($order->callback != null) {
                return redirect($order->callback . '&status=success');
            }else{
                return \redirect()->route('payment-success');
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

    /**
     * Summary of cancel
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function cancel(Request $request)
    {
        $order = Order::where('id',$request['payment_id'])->first();
        $order->order_status = 'canceled';
        $order->failed = now();
        $order->save();
        if ($order->callback != null) {
            return redirect($order->callback . '&status=canceled');
        }else{
            return \redirect()->route('payment-canceled');
        }
    }
}
