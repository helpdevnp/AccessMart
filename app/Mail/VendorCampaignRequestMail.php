<?php

namespace App\Mail;

use App\CentralLogics\Helpers;
use App\Models\BusinessSetting;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorCampaignRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $name;
    protected $status;

    public function __construct($name,$status)
    {
        $this->name = $name;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('email-templates.add-fund')->with(['data'=>$this->data]);


        $company_name = BusinessSetting::where('key', 'business_name')->first()->value;
        $status = $this->status;
        if($status == 'approved'){
            $data=EmailTemplate::where('type','store')->where('email_type', 'campaign_approve')->first();
            $template=$data?$data->email_template:1;
        }elseif($status == 'denied'){
            $data=EmailTemplate::where('type','store')->where('email_type', 'campaign_deny')->first();
            $template=$data?$data->email_template:7;
        }elseif($status == 'pending'){
            $data=EmailTemplate::where('type','store')->where('email_type', 'campaign_request')->first();
            $template=$data?$data->email_template:7;
        }
            
        $store_name = $this->name;
        $title = Helpers::text_variable_data_format( value:$data['title']??'',store_name:$store_name??'',transaction_id:$transaction_id??'');
        $body = Helpers::text_variable_data_format( value:$data['body']??'',store_name:$store_name??'',transaction_id:$transaction_id??'');
        $footer_text = Helpers::text_variable_data_format( value:$data['footer_text']??'',store_name:$store_name??'',transaction_id:$transaction_id??'');
        $copyright_text = Helpers::text_variable_data_format( value:$data['copyright_text']??'',store_name:$store_name??'',transaction_id:$transaction_id??'');
        return $this->view('email-templates.new-email-format-'.$template, ['company_name'=>$company_name,'data'=>$data,'title'=>$title,'body'=>$body,'footer_text'=>$footer_text,'copyright_text'=>$copyright_text]);
    }
}
