<?php

namespace App\Mail;

use App\CentralLogics\Helpers;
use App\Models\BusinessSetting;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DmSelfRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $status;
    protected $name;

    public function __construct($status, $name)
    {
        $this->status = $status;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('email-templates.self-registration')->with(['status'=>$this->status, 'name'=>$this->name]);

        $company_name = BusinessSetting::where('key', 'business_name')->first()->value;
        $status = $this->status;
        if($status == 'approved'){
            $data=EmailTemplate::where('type','dm')->where('email_type', 'approve')->first();
        }elseif($status == 'denied'){
            $data=EmailTemplate::where('type','dm')->where('email_type', 'deny')->first();
        }else{
            $data=EmailTemplate::where('type','dm')->where('email_type', 'registration')->first();
        }
        $template=$data?$data->email_template:5;
        $url = '';
        $dm_name = $this->name;
        $title = Helpers::text_variable_data_format( value:$data['title']??'',delivery_man_name:$dm_name??'');
        $body = Helpers::text_variable_data_format( value:$data['body']??'',delivery_man_name:$dm_name??'');
        $footer_text = Helpers::text_variable_data_format( value:$data['footer_text']??'',delivery_man_name:$dm_name??'');
        $copyright_text = Helpers::text_variable_data_format( value:$data['copyright_text']??'',delivery_man_name:$dm_name??'');
        return $this->view('email-templates.new-email-format-'.$template, ['company_name'=>$company_name,'data'=>$data,'title'=>$title,'body'=>$body,'footer_text'=>$footer_text,'copyright_text'=>$copyright_text,'url'=>$url]);
    }
}
