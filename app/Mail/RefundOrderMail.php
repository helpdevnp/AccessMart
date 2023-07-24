<?php

namespace App\Mail;

use App\CentralLogics\Helpers;
use App\Models\BusinessSetting;
use App\Models\EmailTemplate;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundedOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $o_id;

    public function __construct($o_id)
    {
        $this->o_id = $o_id;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order_id = $this->o_id;
        $order=Order::where('id', $order_id)->first();
        $company_name = BusinessSetting::where('key', 'business_name')->first()->value;
        $data=EmailTemplate::where('type','user')->where('email_type', 'refund_order')->first();
        $template=$data?$data->email_template:9;
        $user_name = $order->customer->f_name.' '.$order->customer->l_name;
        $store_name = $order->store->name;
        $delivery_man_name = $order->delivery_man?->f_name.''.$order->delivery_man?->l_name;
        $title = Helpers::text_variable_data_format( value:$data['title']??'',user_name:$user_name??'',store_name:$store_name??'',delivery_man_name:$delivery_man_name??'',order_id:$order_id??'');
        $body = Helpers::text_variable_data_format( value:$data['body']??'',user_name:$user_name??'',store_name:$store_name??'',delivery_man_name:$delivery_man_name??'',order_id:$order_id??'');
        $footer_text = Helpers::text_variable_data_format( value:$data['footer_text']??'',user_name:$user_name??'',store_name:$store_name??'',delivery_man_name:$delivery_man_name??'',order_id:$order_id??'');
        $copyright_text = Helpers::text_variable_data_format( value:$data['copyright_text']??'',user_name:$user_name??'',store_name:$store_name??'',delivery_man_name:$delivery_man_name??'',order_id:$order_id??'');
        return $this->view('email-templates.new-email-format-'.$template, ['company_name'=>$company_name,'data'=>$data,'title'=>$title,'body'=>$body,'footer_text'=>$footer_text,'copyright_text'=>$copyright_text,'order'=>$order]);
    }
}