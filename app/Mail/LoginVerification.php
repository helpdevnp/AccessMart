<?php

namespace App\Mail;

use App\CentralLogics\Helpers;
use App\Models\BusinessSetting;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $reset_url;
    protected $name;

    public function __construct($reset_url,$name)
    {
        $this->reset_url = $reset_url;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $reset_url = $this->reset_url;
        // return $this->view('email-templates.email-valification', ['reset_url' => $reset_url]);

        $company_name = BusinessSetting::where('key', 'business_name')->first()->value;
        $data=EmailTemplate::where('type','user')->where('email_type', 'login_otp')->first();
        $template=$data?$data->email_template:4;
        $code = $this->reset_url;
        $user_name = $this->name;
        $title = Helpers::text_variable_data_format( value:$data['title']??'',user_name:$user_name??'');
        $body = Helpers::text_variable_data_format( value:$data['body']??'',user_name:$user_name??'');
        $footer_text = Helpers::text_variable_data_format( value:$data['footer_text']??'',user_name:$user_name??'');
        $copyright_text = Helpers::text_variable_data_format( value:$data['copyright_text']??'',user_name:$user_name??'');
        return $this->view('email-templates.new-email-format-'.$template, ['company_name'=>$company_name,'data'=>$data,'title'=>$title,'body'=>$body,'footer_text'=>$footer_text,'copyright_text'=>$copyright_text,'code'=>$code]);
    }
}
