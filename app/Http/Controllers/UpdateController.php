<?php

namespace App\Http\Controllers;

use App\Models\DataSetting;
use Illuminate\Http\Request;

ini_set('max_execution_time', 180);

use App\Models\EmailTemplate;
use App\CentralLogics\Helpers;
use App\Traits\ActivationClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class UpdateController extends Controller
{
    use ActivationClass;

    public function update_software_index()
    {
        return view('update.update-software');
    }

    public function update_software(Request $request)
    {
        if (env('SOFTWARE_VERSION') == '1.0') {
            $filesystem = new Filesystem;
            $filesystem->cleanDirectory('database/migrations');
        }

        Helpers::setEnvironmentValue('BUYER_USERNAME', $request['username']);
        Helpers::setEnvironmentValue('PURCHASE_CODE', $request['purchase_key']);
        Helpers::setEnvironmentValue('APP_MODE', 'live');
        Helpers::setEnvironmentValue('SOFTWARE_VERSION', '2.2.1');
        Helpers::setEnvironmentValue('REACT_APP_KEY', '45370351');
        Helpers::setEnvironmentValue('APP_NAME', '6amMart' . time());

        // $data = Helpers::requestSender();
        // if (!$data['active']) {
        if (!$this->actch()) {
            return redirect(base64_decode('aHR0cHM6Ly82YW10ZWNoLmNvbS9zb2Z0d2FyZS1hY3RpdmF0aW9u'));
        }

        Artisan::call('migrate', ['--force' => true]);
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Helpers::insert_business_settings_key("mobile_app_section_heading" , "Download the App for Enjoy Best Restaurant Test");
        Helpers::insert_business_settings_key("mobile_app_section_text" , "Default Text Mobile App Section");
        Helpers::insert_business_settings_key("feature_section_description" , "Feature section description");
        Helpers::insert_business_settings_key("Feature section description", json_encode([
            "app_url_android_status" => "0",
            "app_url_android" => "https://play.google.com",
            "app_url_ios_status" => "0",
            "app_url_ios" => "https://www.apple.com/app-store",
            "web_app_url_status" => "0",
            "web_app_url" => "https://stackfood.6amtech.com/"
        ]));

        //version 1.5.0
        Helpers::insert_business_settings_key("wallet_status" , "0");
        Helpers::insert_business_settings_key("loyalty_point_status" , "0");
        Helpers::insert_business_settings_key("ref_earning_status" , "0");
        Helpers::insert_business_settings_key("wallet_add_refund" , "0");
        Helpers::insert_business_settings_key("loyalty_point_exchange_rate" , "0");
        Helpers::insert_business_settings_key("ref_earning_exchange_rate" , "0");
        Helpers::insert_business_settings_key("loyalty_point_item_purchase_point" , "0");
        Helpers::insert_business_settings_key("loyalty_point_minimum_point" , "0");
        Helpers::insert_business_settings_key("dm_tips_status" , "0");
        Helpers::insert_business_settings_key('tax_included', '0');
        Helpers::insert_business_settings_key('refund_active_status', '1');
        Helpers::insert_business_settings_key('social_login','[{"login_medium":"google","client_id":"","client_secret":"","status":"0"},{"login_medium":"facebook","client_id":"","client_secret":"","status":""}]');
        Helpers::insert_business_settings_key('system_language','[{"id":1,"direction":"ltr","code":"en","status":1,"default":true}]');
        Helpers::insert_business_settings_key('language','["en"]');
        //version 2.0.1
        // Helpers::insert_business_settings_key('otp_interval_time', '30');
        // Helpers::insert_business_settings_key('max_otp_hit', '5');

        Helpers::insert_business_settings_key("home_delivery_status" , "1");
        Helpers::insert_business_settings_key("takeaway_status" , "1");

        $data_settings = file_get_contents('database/partial/data_settings.sql');
        $email_tempaltes = file_get_contents('database/partial/email_tempaltes.sql');

        if( DataSetting::count() < 1){
            DB::statement($data_settings);
        }
        if( EmailTemplate::count() < 1){
            DB::statement($email_tempaltes);
        }

        //version 2.2.0
        Helpers::insert_data_settings_key('admin_login_url', 'login_admin' ,'admin');
        Helpers::insert_data_settings_key('admin_employee_login_url', 'login_admin_employee' ,'admin-employee');
        Helpers::insert_data_settings_key('store_login_url', 'login_store' ,'store');
        Helpers::insert_data_settings_key('store_employee_login_url', 'login_store_employee' ,'store-employee');


        $data = DataSetting::where('type', 'login_admin')->pluck('value')->first();
        return redirect('/login/'.$data);
    }
}
