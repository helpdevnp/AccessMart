<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\Currency;
use App\Models\DataSetting;
use App\Models\DMVehicle;
use App\Models\FlutterSpecialCriteria;
use App\Models\Module;
use App\Models\ReactTestimonial;
use App\Models\SocialMedia;
use App\Models\Zone;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConfigController extends Controller
{
    private $map_api_key;

    function __construct()
    {
        $map_api_key_server=BusinessSetting::where(['key'=>'map_api_key_server'])->first();
        $map_api_key_server=$map_api_key_server?$map_api_key_server->value:null;
        $this->map_api_key = $map_api_key_server;
    }

    public function configuration()
    {
        $key = ['currency_code','cash_on_delivery','digital_payment','default_location','free_delivery_over','business_name','logo','address','phone','email_address','country','currency_symbol_position','app_minimum_version_android','app_url_android','app_minimum_version_ios','app_url_ios','app_url_android_store','app_minimum_version_ios_store','app_url_ios_store','app_minimum_version_ios_deliveryman','app_url_ios_deliveryman','app_minimum_version_android_deliveryman','app_minimum_version_android_store', 'app_url_android_deliveryman', 'customer_verification','schedule_order','order_delivery_verification','per_km_shipping_charge','minimum_shipping_charge','show_dm_earning','canceled_by_deliveryman','canceled_by_store','timeformat','toggle_veg_non_veg','toggle_dm_registration','toggle_store_registration','schedule_order_slot_duration','parcel_per_km_shipping_charge','parcel_minimum_shipping_charge','web_app_landing_page_settings','footer_text','landing_page_links','loyalty_point_exchange_rate', 'loyalty_point_item_purchase_point', 'loyalty_point_status', 'loyalty_point_minimum_point', 'wallet_status', 'dm_tips_status', 'ref_earning_status','ref_earning_exchange_rate','refund_active_status','refund','cancelation','shipping_policy','prescription_order_status','tax_included','icon','cookies_text','home_delivery_status','takeaway_status'];

        $settings =  array_column(BusinessSetting::whereIn('key',$key)->get()->toArray(), 'value', 'key');

        $currency_symbol = Currency::where(['currency_code' => Helpers::currency_code()])->first()->currency_symbol;
        $cod = json_decode($settings['cash_on_delivery'], true);
        $digital_payment = json_decode($settings['digital_payment'], true);
        $default_location=isset($settings['default_location'])?json_decode($settings['default_location'], true):0;
        $free_delivery_over = $settings['free_delivery_over'];
        $free_delivery_over = isset($free_delivery_over)?(float)$free_delivery_over:$free_delivery_over;
        $module = null;
        if(Module::active()->count()==1)
        {
            $module = Module::active()->first();
        }
        $languages = Helpers::get_business_settings('language');
        $lang_array = [];
        foreach ($languages as $language) {
            array_push($lang_array, [
                'key' => $language,
                'value' => Helpers::get_language_name($language)
            ]);
        }
        $system_languages = Helpers::get_business_settings('system_language');
        $sys_lang_array = [];
        foreach ($system_languages as $language) {
            array_push($sys_lang_array, [
                'key' => $language['code'],
                'value' => Helpers::get_language_name($language['code']),
                'direction' => $language['direction'],
                'default' => $language['default']
            ]);
        }
        $social_login = [];
        foreach (Helpers::get_business_settings('social_login') as $social) {
            $config = [
                'login_medium' => $social['login_medium'],
                'status' => (boolean)$social['status']
            ];
            array_push($social_login, $config);
        }
        $apple_login = [];
        $apples = Helpers::get_business_settings('apple_login');
        if(isset($apples)){
            foreach (Helpers::get_business_settings('apple_login') as $apple) {
                $config = [
                    'login_medium' => $apple['login_medium'],
                    'status' => (boolean)$apple['status'],
                    'client_id' => $apple['client_id']
                ];
                array_push($apple_login, $config);
            }
        }

        return response()->json([
            'business_name' => $settings['business_name'],
            // 'business_open_time' => $settings['business_open_time'],
            // 'business_close_time' => $settings['business_close_time'],
            'logo' => $settings['logo'],
            'address' => $settings['address'],
            'phone' => $settings['phone'],
            'email' => $settings['email_address'],
            // 'store_location_coverage' => Branch::where(['id'=>1])->first(['longitude','latitude','coverage']),
            // 'minimum_order_value' => (float)$settings['minimum_order_value'],
            'base_urls' => [
                'item_image_url' => asset('storage/app/public/product'),
                'refund_image_url' => asset('storage/app/public/refund'),
                'customer_image_url' => asset('storage/app/public/profile'),
                'banner_image_url' => asset('storage/app/public/banner'),
                'category_image_url' => asset('storage/app/public/category'),
                'review_image_url' => asset('storage/app/public/review'),
                'notification_image_url' => asset('storage/app/public/notification'),
                'store_image_url' => asset('storage/app/public/store'),
                'vendor_image_url' => asset('storage/app/public/vendor'),
                'store_cover_photo_url' => asset('storage/app/public/store/cover'),
                'delivery_man_image_url' => asset('storage/app/public/delivery-man'),
                'chat_image_url' => asset('storage/app/public/conversation'),
                'campaign_image_url' => asset('storage/app/public/campaign'),
                'business_logo_url' => asset('storage/app/public/business'),
                'order_attachment_url' => asset('storage/app/public/order'),
                'module_image_url' => asset('storage/app/public/module'),
                'parcel_category_image_url' => asset('storage/app/public/parcel_category'),
                'landing_page_image_url' => asset('public/assets/landing/image'),
                'react_landing_page_images' => asset('storage/app/public/react_landing') ,
                'react_landing_page_feature_images' => asset('storage/app/public/react_landing/feature') ,
            ],
            'country' => $settings['country'],
            'default_location'=> [ 'lat'=> $default_location?$default_location['lat']:'23.757989', 'lng'=> $default_location?$default_location['lng']:'90.360587' ],
            'currency_symbol' => $currency_symbol,
            'currency_symbol_direction' => $settings['currency_symbol_position'],
            'app_minimum_version_android' => (float)$settings['app_minimum_version_android'],
            'app_url_android' => $settings['app_url_android'],
            'app_minimum_version_ios' => (float)$settings['app_minimum_version_ios'],
            'app_url_ios' => $settings['app_url_ios'],
            'app_minimum_version_android_store' => (float)(isset($settings['app_minimum_version_android_store']) ? $settings['app_minimum_version_android_store'] : 0),
            'app_url_android_store' => (isset($settings['app_url_android_store']) ? $settings['app_url_android_store'] : null),
            'app_minimum_version_ios_store' => (float)(isset($settings['app_minimum_version_ios_store']) ? $settings['app_minimum_version_ios_store'] : 0),
            'app_url_ios_store' => (isset($settings['app_url_ios_store']) ? $settings['app_url_ios_store'] : null),
            'app_minimum_version_android_deliveryman' => (float)(isset($settings['app_minimum_version_android_deliveryman']) ? $settings['app_minimum_version_android_deliveryman'] : 0),
            'app_url_android_deliveryman' => (isset($settings['app_url_android_deliveryman']) ? $settings['app_url_android_deliveryman'] : null),
            'app_minimum_version_ios_deliveryman' => (float)(isset($settings['app_minimum_version_ios_deliveryman']) ? $settings['app_minimum_version_ios_deliveryman'] : 0),
            'app_url_ios_deliveryman' => (isset($settings['app_url_ios_deliveryman']) ? $settings['app_url_ios_deliveryman'] : null),
            'customer_verification' => (boolean)$settings['customer_verification'],
            'prescription_order_status' => isset($settings['prescription_order_status'])?(boolean)$settings['prescription_order_status']:false,
            'schedule_order' => (boolean)$settings['schedule_order'],
            'order_delivery_verification' => (boolean)$settings['order_delivery_verification'],
            'cash_on_delivery' => (boolean)($cod['status'] == 1 ? true : false),
            'digital_payment' => (boolean)($digital_payment['status'] == 1 ? true : false),
            'per_km_shipping_charge' => (double)$settings['per_km_shipping_charge'],
            'minimum_shipping_charge' => (double)$settings['minimum_shipping_charge'],
            'free_delivery_over'=>$free_delivery_over,
            'demo'=>(boolean)(env('APP_MODE')=='demo'?true:false),
            'maintenance_mode' => (boolean)Helpers::get_business_settings('maintenance_mode') ?? 0,
            'order_confirmation_model'=>config('order_confirmation_model'),
            'show_dm_earning' => (boolean)$settings['show_dm_earning'],
            'canceled_by_deliveryman' => (boolean)$settings['canceled_by_deliveryman'],
            'canceled_by_store' => (boolean)$settings['canceled_by_store'],
            'timeformat' => (string)$settings['timeformat'],
            'language' => $lang_array,
            'sys_language' => $sys_lang_array,
            'social_login' => $social_login,
            'apple_login' => $apple_login,
            'toggle_veg_non_veg' => (boolean)$settings['toggle_veg_non_veg'],
            'toggle_dm_registration' => (boolean)$settings['toggle_dm_registration'],
            'toggle_store_registration' => (boolean)$settings['toggle_store_registration'],
            'refund_active_status' => (boolean)$settings['refund_active_status'],
            'schedule_order_slot_duration' => (int)$settings['schedule_order_slot_duration'],
            'digit_after_decimal_point' => (int)config('round_up_to_digit'),
            'module_config'=>config('module'),
            'module'=>$module,
            'parcel_per_km_shipping_charge' => (float)$settings['parcel_per_km_shipping_charge'],
            'parcel_minimum_shipping_charge' => (float)$settings['parcel_minimum_shipping_charge'],
            'landing_page_settings'=> isset($settings['web_app_landing_page_settings'])?json_decode($settings['web_app_landing_page_settings'], true):null,
            'social_media'=>SocialMedia::active()->get()->toArray(),
            'footer_text'=>isset($settings['footer_text'])?$settings['footer_text']:'',
            'cookies_text'=>isset($settings['cookies_text'])?$settings['cookies_text']:'',
            'fav_icon' => $settings['icon'],
            'landing_page_links'=>isset($settings['landing_page_links'])?json_decode($settings['landing_page_links']):[],
            //Added Business Setting
            'dm_tips_status' => (int)(isset($settings['dm_tips_status']) ? $settings['dm_tips_status'] : 0),
            'loyalty_point_exchange_rate' => (int)(isset($settings['loyalty_point_item_purchase_point']) ? $settings['loyalty_point_exchange_rate'] : 0),
            'loyalty_point_item_purchase_point' => (float)(isset($settings['loyalty_point_item_purchase_point']) ? $settings['loyalty_point_item_purchase_point'] : 0.0),
            'loyalty_point_status' => (int)(isset($settings['loyalty_point_status']) ? $settings['loyalty_point_status'] : 0),
            'customer_wallet_status' => (int)(isset($settings['wallet_status']) ? $settings['wallet_status'] : 0),
            'ref_earning_status' => (int)(isset($settings['ref_earning_status']) ? $settings['ref_earning_status'] : 0),
            'ref_earning_exchange_rate' => (double)(isset($settings['ref_earning_exchange_rate']) ? $settings['ref_earning_exchange_rate'] : 0),
            'refund_policy' => (int)(self::get_settings_status('refund_policy_status')),
            'cancelation_policy' => (int)(self::get_settings_status('cancellation_policy_status')),
            'shipping_policy' => (int)(self::get_settings_status('shipping_policy_status')),
            'loyalty_point_minimum_point' => (int)(isset($settings['loyalty_point_minimum_point']) ? $settings['loyalty_point_minimum_point'] : 0),
            'tax_included' => (int)(isset($settings['tax_included']) ? $settings['tax_included'] : 0),
            'home_delivery_status' => (int)(isset($settings['home_delivery_status']) ? $settings['home_delivery_status'] : 0),
            'takeaway_status' => (int)(isset($settings['takeaway_status']) ? $settings['takeaway_status'] : 0),
        ]);
    }

    public static function get_settings_status($name)
    {
        $data = DataSetting::where(['key' => $name])->first()?->value;
        return $data??0;
    }

    public function get_zone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $zones = Zone::with('modules')->whereContains('coordinates', new Point($request->lat, $request->lng, POINT_SRID))->latest()->get(['id', 'status', 'cash_on_delivery', 'digital_payment']);
        if(count($zones)<1)
        {
            return response()->json([
                'errors'=>[
                    ['code'=>'coordinates','message'=>translate('messages.service_not_available_in_this_area')]
                ]
            ], 404);
        }
        $data = array_filter($zones->toArray(), function($zone){
            if($zone['status'] == 1) {
                return $zone;
            }
        });

        if (count($data) > 0) {
            return response()->json(['zone_id' => json_encode(array_column($data, 'id')), 'zone_data'=>array_values($data)], 200);
        }

        return response()->json([
            'errors'=>[
                ['code'=>'coordinates','message'=>translate('messages.we_are_temporarily_unavailable_in_this_area')]
            ]
        ], 403);
    }

    public function place_api_autocomplete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_text' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $response = Http::get('https://maps.googleapis.com/maps/api/place/autocomplete/json?input='.$request['search_text'].'&key='.$this->map_api_key);
        return $response->json();
    }


    public function distance_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin_lat' => 'required',
            'origin_lng' => 'required',
            'destination_lat' => 'required',
            'destination_lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$request['origin_lat'].','.$request['origin_lng'].'&destinations='.$request['destination_lat'].','.$request['destination_lng'].'&key='.$this->map_api_key.'&mode=walking');
        return $response->json();
    }


    public function place_api_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placeid' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json?placeid='.$request['placeid'].'&key='.$this->map_api_key);
        return $response->json();
    }

    public function geocode_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$request->lat.','.$request->lng.'&key='.$this->map_api_key);
        return $response->json();
    }

    public function landing_page(){
        $key =['react_header_banner','banner_section_full','banner_section_half' ,'footer_logo','app_section_image',
        'react_feature','app_download_button' ,'discount_banner','landing_page_links','delivery_service_section','hero_section','download_app_section','landing_page_text'];
        $settings =  array_column(BusinessSetting::whereIn('key', $key)->get()->toArray(), 'value', 'key');
        return  response()->json(
            [
                'react_header_banner'=>(isset($settings['react_header_banner']) )  ? $settings['react_header_banner'] : null ,
                'app_section_image'=> (isset($settings['app_section_image'])) ? $settings['app_section_image']  : null,
                'footer_logo'=> (isset($settings['footer_logo'])) ? $settings['footer_logo'] : null,
                'banner_section_full'=> (isset($settings['banner_section_full']) )  ? json_decode($settings['banner_section_full'], true) : null ,
                'banner_section_half'=>(isset($settings['banner_section_half']) )  ? json_decode($settings['banner_section_half'], true) : [],
                'react_feature'=> (isset($settings['react_feature'])) ? json_decode($settings['react_feature'], true) : [],
                'app_download_button'=> (isset($settings['app_download_button'])) ? json_decode($settings['app_download_button'], true) : [],
                'discount_banner'=> (isset($settings['discount_banner'])) ? json_decode($settings['discount_banner'], true) : null,
                'landing_page_links'=> (isset($settings['landing_page_links'])) ? json_decode($settings['landing_page_links'], true) : null,
                'hero_section'=> (isset($settings['hero_section'])) ? json_decode($settings['hero_section'], true) : null,
                'delivery_service_section'=> (isset($settings['delivery_service_section'])) ? json_decode($settings['delivery_service_section'], true) : null,
                'download_app_section'=> (isset($settings['download_app_section'])) ? json_decode($settings['download_app_section'], true) : null,
                'landing_page_text'=> (isset($settings['landing_page_text'])) ? json_decode($settings['landing_page_text'], true) : null,
        ]);
    }

    public function extra_charge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'distance' => 'required',
        ]);
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $distance_data = $request->distance ?? 1;
        $data = DmVehicle::active()
        ->where(function ($query) use ($distance_data) {
            $query->where('starting_coverage_area', '<=', $distance_data)->where('maximum_coverage_area', '>=', $distance_data)
            ->orWhere(function ($query) use ($distance_data) {
                $query->where('starting_coverage_area', '>=', $distance_data);
            });
        })->orderBy('starting_coverage_area')->first();

            $extra_charges = (float) (isset($data) ? $data->extra_charges  : 0);
        return response()->json($extra_charges,200);
    }

    public function get_vehicles(Request $request){
        $data = DMVehicle::active()->get(['id','type']);
        return response()->json($data, 200);
    }

    public function react_landing_page()
    {
        $datas =  DataSetting::with('translations')->where('type','react_landing_page')->get();
        $data = [];
        foreach ($datas as $key => $value) {
            if(count($value->translations)>0){
                $cred = [
                    $value->key => $value->translations[0]['value'],
                ];
                array_push($data,$cred);
            }else{
                $cred = [
                    $value->key => $value->value,
                ];
                array_push($data,$cred);
            }
        }
        $settings = [];
        foreach($data as $single_data){
            foreach($single_data as $key=>$single_value){
                $settings[$key] = $single_value;
            }
        }
        
        $reviews = ReactTestimonial::get();

        return  response()->json(
            [
                'base_urls' => [
                    'header_icon_url' => asset('storage/app/public/header_icon'),
                    'header_banner_url' => asset('storage/app/public/header_banner'),
                    'testimonial_image_url' => asset('storage/app/public/reviewer_image'),
                    'promotional_banner_url' => asset('storage/app/public/promotional_banner'),
                    'business_image_url' => asset('storage/app/public/business_image'),
                ],

                'header_title'=>(isset($settings['header_title']) )  ? $settings['header_title'] : null ,
                'header_sub_title'=>(isset($settings['header_sub_title']) )  ? $settings['header_sub_title'] : null ,
                'header_tag_line'=>(isset($settings['header_tag_line']) )  ? $settings['header_tag_line'] : null ,
                'header_icon'=>(isset($settings['header_icon']) )  ? $settings['header_icon'] : null ,
                'header_banner'=>(isset($settings['header_banner']) )  ? $settings['header_banner'] : null ,
                'company_title'=>(isset($settings['company_title']) )  ? $settings['company_title'] : null ,
                'company_sub_title'=>(isset($settings['company_sub_title']) )  ? $settings['company_sub_title'] : null ,
                'company_description'=>(isset($settings['company_description']) )  ? $settings['company_description'] : null ,
                'company_button_name'=>(isset($settings['company_button_name']) )  ? $settings['company_button_name'] : null ,
                'company_button_url'=>(isset($settings['company_button_url']) )  ? $settings['company_button_url'] : null ,
                'download_user_app_title'=>(isset($settings['download_user_app_title']) )  ? $settings['download_user_app_title'] : null ,
                'download_user_app_sub_title'=>(isset($settings['download_user_app_sub_title']) )  ? $settings['download_user_app_sub_title'] : null ,
                'earning_title'=>(isset($settings['earning_title']) )  ? $settings['earning_title'] : null ,
                'earning_sub_title'=>(isset($settings['earning_sub_title']) )  ? $settings['earning_sub_title'] : null ,
                'earning_seller_title'=>(isset($settings['earning_seller_title']) )  ? $settings['earning_seller_title'] : null ,
                'earning_seller_sub_title'=>(isset($settings['earning_seller_sub_title']) )  ? $settings['earning_seller_sub_title'] : null ,
                'earning_seller_button_name'=>(isset($settings['earning_seller_button_name']) )  ? $settings['earning_seller_button_name'] : null ,
                'earning_seller_button_url'=>(isset($settings['earning_seller_button_url']) )  ? $settings['earning_seller_button_url'] : null ,
                'earning_dm_title'=>(isset($settings['earning_dm_title']) )  ? $settings['earning_dm_title'] : null ,
                'earning_dm_sub_title'=>(isset($settings['earning_dm_sub_title']) )  ? $settings['earning_dm_sub_title'] : null ,
                'earning_dm_button_name'=>(isset($settings['earning_dm_button_name']) )  ? $settings['earning_dm_button_name'] : null ,
                'earning_dm_button_url'=>(isset($settings['earning_dm_button_url']) )  ? $settings['earning_dm_button_url'] : null ,
                'business_title'=>(isset($settings['business_title']) )  ? $settings['business_title'] : null ,
                'business_sub_title'=>(isset($settings['business_sub_title']) )  ? $settings['business_sub_title'] : null ,
                'business_image'=>(isset($settings['business_image']) )  ? $settings['business_image'] : null ,
                'testimonial_title'=>(isset($settings['testimonial_title']) )  ? $settings['testimonial_title'] : null ,
                'testimonial_list'=>(isset($reviews) )  ? $reviews : null ,
                'fixed_newsletter_title'=>(isset($settings['fixed_newsletter_title']) )  ? $settings['fixed_newsletter_title'] : null ,
                'fixed_newsletter_sub_title'=>(isset($settings['fixed_newsletter_sub_title']) )  ? $settings['fixed_newsletter_sub_title'] : null ,
                'fixed_footer_description'=>(isset($settings['fixed_footer_description']) )  ? $settings['fixed_footer_description'] : null ,
                'fixed_promotional_banner'=>(isset($settings['fixed_promotional_banner']) )  ? $settings['fixed_promotional_banner'] : null ,



                'promotion_banners'=> (isset($settings['promotion_banner']) )  ? json_decode($settings['promotion_banner'], true) : null ,
                'download_user_app_links'=> (isset($settings['download_user_app_links']) )  ? json_decode($settings['download_user_app_links'], true) : null ,
                'download_business_app_links'=> (isset($settings['download_business_app_links']) )  ? json_decode($settings['download_business_app_links'], true) : null ,
                // 'dm_app_earning_links'=> (isset($settings['dm_app_earning_links']) )  ? json_decode($settings['dm_app_earning_links'], true) : null ,
                // 'download_user_app_links'=> (isset($settings['download_app_links']) )  ? json_decode($settings['download_app_links'], true) : null ,
        ]);
    }

    public function flutter_landing_page()
    {
        $datas =  DataSetting::with('translations')->where('type','flutter_landing_page')->get();
        $data = [];
        foreach ($datas as $key => $value) {
            if(count($value->translations)>0){
                $cred = [
                    $value->key => $value->translations[0]['value'],
                ];
                array_push($data,$cred);
            }else{
                $cred = [
                        $value->key => $value->value,
                    ];
                array_push($data,$cred);
            }
        }
        $settings = [];
        foreach($data as $single_data){
                foreach($single_data as $key=>$single_value){
                        $settings[$key] = $single_value;
                    }
                }
        
        $criterias = FlutterSpecialCriteria::get();

        return  response()->json(
            [
                'base_urls' => [
                    'fixed_header_image' => asset('storage/app/public/fixed_header_image'),
                    'special_criteria_image' => asset('storage/app/public/special_criteria'),
                    'download_user_app_image' => asset('storage/app/public/download_user_app_image'),
                ],

                'fixed_header_title'=>(isset($settings['fixed_header_title']) )  ? $settings['fixed_header_title'] : null ,
                'fixed_header_sub_title'=>(isset($settings['fixed_header_sub_title']) )  ? $settings['fixed_header_sub_title'] : null ,
                'fixed_header_image'=>(isset($settings['fixed_header_image']) )  ? $settings['fixed_header_image'] : null ,
                'fixed_module_title'=>(isset($settings['fixed_module_title']) )  ? $settings['fixed_module_title'] : null ,
                'fixed_module_sub_title'=>(isset($settings['fixed_module_sub_title']) )  ? $settings['fixed_module_sub_title'] : null ,
                'fixed_location_title'=>(isset($settings['fixed_location_title']) )  ? $settings['fixed_location_title'] : null ,
                'join_seller_title'=>(isset($settings['join_seller_title']) )  ? $settings['join_seller_title'] : null ,
                'join_seller_sub_title'=>(isset($settings['join_seller_sub_title']) )  ? $settings['join_seller_sub_title'] : null ,
                'join_seller_button_name'=>(isset($settings['join_seller_button_name']) )  ? $settings['join_seller_button_name'] : null ,
                'join_seller_button_url'=>(isset($settings['join_seller_button_url']) )  ? $settings['join_seller_button_url'] : null ,
                'join_delivery_man_title'=>(isset($settings['join_delivery_man_title']) )  ? $settings['join_delivery_man_title'] : null ,
                'join_delivery_man_sub_title'=>(isset($settings['join_delivery_man_sub_title']) )  ? $settings['join_delivery_man_sub_title'] : null ,
                'join_delivery_man_button_name'=>(isset($settings['join_delivery_man_button_name']) )  ? $settings['join_delivery_man_button_name'] : null ,
                'join_delivery_man_button_url'=>(isset($settings['join_delivery_man_button_url']) )  ? $settings['join_delivery_man_button_url'] : null ,
                'download_user_app_title'=>(isset($settings['download_user_app_title']) )  ? $settings['download_user_app_title'] : null ,
                'download_user_app_sub_title'=>(isset($settings['download_user_app_sub_title']) )  ? $settings['download_user_app_sub_title'] : null ,
                'download_user_app_image'=>(isset($settings['download_user_app_image']) )  ? $settings['download_user_app_image'] : null ,
                
                'special_criterias'=>(isset($criterias) )  ? $criterias : null ,



                'download_user_app_links'=> (isset($settings['download_user_app_links']) )  ? json_decode($settings['download_user_app_links'], true) : null ,
        ]);
    }
}
