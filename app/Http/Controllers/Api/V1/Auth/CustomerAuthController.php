<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use Illuminate\Support\Carbon;
use App\Mail\EmailVerification;
use App\Models\BusinessSetting;
use App\CentralLogics\SMS_module;
use App\Models\WalletTransaction;
use App\Models\EmailVerifications;
use Illuminate\Support\Facades\DB;
use App\CentralLogics\CustomerLogic;
use App\Http\Controllers\Controller;
use App\Mail\LoginVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CustomerAuthController extends Controller
{
    public function verify_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:11|max:14',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->is_phone_verified) {
                return response()->json([
                    'message' => translate('messages.phone_number_is_already_varified')
                ], 200);
            }

            if (env('APP_MODE') == 'demo') {
                if ($request['otp'] == "1234") {
                    $user->is_phone_verified = 1;
                    $user->save();

                    return response()->json([
                        'message' => translate('messages.phone_number_varified_successfully'),
                        'otp' => 'inactive'
                    ], 200);
                }
                return response()->json([
                    'message' => translate('messages.phone_number_and_otp_not_matched')
                ], 404);
            }

            $data = DB::table('phone_verifications')->where([
                'phone' => $request['phone'],
                'token' => $request['otp'],
            ])->first();

            if ($data) {
                DB::table('phone_verifications')->where([
                    'phone' => $request['phone'],
                    'token' => $request['otp'],
                ])->delete();

                $user->is_phone_verified = 1;
                $user->save();

                return response()->json([
                    'message' => translate('messages.phone_number_varified_successfully'),
                    'otp' => 'inactive'
                ], 200);
            } else {
                 // $otp_hit = BusinessSetting::where('key', 'max_otp_hit')->first();
                // $max_otp_hit =isset($otp_hit) ? $otp_hit->value : 5 ;
                $max_otp_hit = 5;

                // $otp_hit_time = BusinessSetting::where('key', 'max_otp_hit_time')->first();
                // $max_otp_hit_time =isset($otp_hit_time) ? $otp_hit_time->value : 30 ;

                $max_otp_hit_time = 60; // seconds
                $temp_block_time = 600; // seconds

                $verification_data= DB::table('phone_verifications')->where('phone', $request['phone'])->first();

                if(isset($verification_data)){


                    // if($verification_data->is_blocked == 1){
                    //     $errors = [];
                    //     array_push($errors, ['code' => 'otp', 'message' => translate('messages.your_account_is_blocked')]);
                    //     return response()->json(['errors' => $errors ], 403);
                    // }



                    if(isset($verification_data->temp_block_time ) && Carbon::parse($verification_data->temp_block_time)->DiffInSeconds() <= $temp_block_time){
                        $time= $temp_block_time - Carbon::parse($verification_data->temp_block_time)->DiffInSeconds();

                        $errors = [];
                        array_push($errors, ['code' => 'otp_block_time',
                        'message' => translate('messages.please_try_again_after_').CarbonInterval::seconds($time)->cascade()->forHumans()
                         ]);
                        return response()->json([
                            'errors' => $errors
                        ], 405);
                    }

                    if($verification_data->is_temp_blocked == 1 && Carbon::parse($verification_data->updated_at)->DiffInSeconds() >= $max_otp_hit_time){
                        DB::table('phone_verifications')->updateOrInsert(['phone' => $request['phone']],
                            [
                                'otp_hit_count' => 0,
                                'is_temp_blocked' => 0,
                                'temp_block_time' => null,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }

                    // if($verification_data->is_temp_blocked == 1 && Carbon::parse($verification_data->updated_at)->DiffInSeconds() < $max_otp_hit_time){
                    //         $errors = [];
                    //     array_push($errors, ['code' => 'otp', 'message' => translate('messages.please_try_again_after_').$time.' '.translate('messages.seconds') ]);
                    //     return response()->json([
                    //         'errors' => $errors
                    //     ], 405);
                    //     }

                    if($verification_data->otp_hit_count >= $max_otp_hit &&  Carbon::parse($verification_data->updated_at)->DiffInSeconds() < $max_otp_hit_time &&  $verification_data->is_temp_blocked == 0){

                        DB::table('phone_verifications')->updateOrInsert(['phone' => $request['phone']],
                            [
                            'is_temp_blocked' => 1,
                            'temp_block_time' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                            ]);
                        $errors = [];
                        array_push($errors, ['code' => 'otp_temp_blocked', 'message' => translate('messages.Too_many_attemps') ]);
                        return response()->json([
                            'errors' => $errors
                        ], 405);
                    }


                    // if($verification_data->otp_hit_count >= $max_otp_hit &&  Carbon::parse($verification_data->updated_at)->DiffInSeconds() < $max_otp_hit_time){

                    //     DB::table('phone_verifications')->updateOrInsert(['phone' => $request['phone']],
                    //         [
                    //         // 'is_temp_blocked' => 1,
                    //         'created_at' => now(),
                    //         'updated_at' => now(),
                    //         ]);
                    //         // $errors = [];
                    //         array_push($errors, ['code' => 'otp_warning', 'message' =>translate('messages.Too_many_attemps') ]);
                    //         return response()->json([
                    //             'errors' => $errors
                    //         ], 405);
                    // }
                }


                DB::table('phone_verifications')->updateOrInsert(['phone' => $request['phone']],
                [
                'otp_hit_count' => DB::raw('otp_hit_count + 1'),
                'updated_at' => now(),
                'temp_block_time' => null,
                ]);

                return response()->json([
                    'message' => translate('messages.phone_number_and_otp_not_matched')
                ], 404);
            }
        }
        return response()->json([
            'message' => translate('messages.not_found')
        ], 404);
    }

    public function check_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }


        if (BusinessSetting::where(['key' => 'email_verification'])->first()->value) {
            $token = rand(1000, 9999);
            DB::table('email_verifications')->insert([
                'email' => $request['email'],
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $mail_status = Helpers::get_mail_status('registration_otp_mail_status_user');
            if (config('mail.status') && $mail_status == '1') {
                $user = User::where('email', $request['email'])->first();
                Mail::to($request['email'])->send(new EmailVerification($token,$user->f_name));
            }
            return response()->json([
                'message' => 'Email is ready to register',
                'token' => 'active'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Email is ready to register',
                'token' => 'inactive'
            ], 200);
        }
    }

    public function verify_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $verify = EmailVerifications::where(['email' => $request['email'], 'token' => $request['token']])->first();

        if (isset($verify)) {
            $verify->delete();
            return response()->json([
                'message' => translate('messages.token_varified'),
            ], 200);
        }

        $errors = [];
        array_push($errors, ['code' => 'token', 'message' => translate('messages.token_not_found')]);
        return response()->json(
            ['errors' => $errors],
            404
        );
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
        ], [
            'f_name.required' => 'The first name field is required.',
            'l_name.required' => 'The last name field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $ref_by= null ;
        $customer_verification = BusinessSetting::where('key', 'customer_verification')->first()->value;

        if($request->ref_code) {
            $ref_status = BusinessSetting::where('key','ref_earning_status')->first()->value;
            if ($ref_status != '1') {
                return response()->json(['errors'=>Helpers::error_formater('ref_code', translate('messages.referer_disable'))], 403);
            }

            $referar_user = User::where('ref_code', '=', $request->ref_code)->first();
            if (!$referar_user || !$referar_user->status) {
                return response()->json(['errors'=>Helpers::error_formater('ref_code',translate('messages.referer_code_not_found'))], 405);
            }

            if(WalletTransaction::where('reference', $request->phone)->first()) {
                return response()->json(['errors'=>Helpers::error_formater('phone',translate('Referrer code already used'))], 203);
            }

            // $ref_code_exchange_amt = BusinessSetting::where('key','ref_earning_exchange_rate')->first()->value;

            // $refer_wallet_transaction = CustomerLogic::create_wallet_transaction($referar_user->id, $ref_code_exchange_amt, 'referrer',$request->phone);
            //dd($refer_wallet_transaction);
            // try{
            //     if(config('mail.status')) {
            //         Mail::to($referar_user->email)->send(new \App\Mail\AddFundToWallet($refer_wallet_transaction));
            //     }
            // }catch(\Exception $ex)
            // {
            //     info($ex->getMessage());
            // }

            $ref_by= $referar_user->id;
        }

        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'ref_by' =>   $ref_by,
            'password' => bcrypt($request->password),
        ]);
        $user->ref_code = Helpers::generate_referer_code($user);
        $user->save();



        $token = $user->createToken('RestaurantCustomerAuth')->accessToken;

        if($customer_verification && env('APP_MODE') !='demo')
        {

            // $interval_time = BusinessSetting::where('key', 'otp_interval_time')->first();
            // $otp_interval_time= isset($interval_time) ? $interval_time->value : 20;
            $otp_interval_time= 60; //seconds
            $verification_data= DB::table('phone_verifications')->where('phone', $request['phone'])->first();

            if(isset($verification_data) &&  Carbon::parse($verification_data->updated_at)->DiffInSeconds() < $otp_interval_time){
                $time= $otp_interval_time - Carbon::parse($verification_data->updated_at)->DiffInSeconds();
                $errors = [];
                array_push($errors, ['code' => 'otp', 'message' =>  translate('messages.please_try_again_after_').$time.' '.translate('messages.seconds')]);
                return response()->json([
                    'errors' => $errors
                ], 405);
            }

            $otp = rand(1000, 9999);
            DB::table('phone_verifications')->updateOrInsert(['phone' => $request['phone']],
                [
                'token' => $otp,
                'otp_hit_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                ]);
                $mail_status = Helpers::get_mail_status('registration_otp_mail_status_user');
                if (config('mail.status') && $mail_status == '1') {
                    Mail::to($request['email'])->send(new EmailVerification($otp,$request->f_name));
                }
            $response = SMS_module::send($request['phone'],$otp);
            if($response != 'success')
            {
                $errors = [];
                array_push($errors, ['code' => 'otp', 'message' => translate('messages.faield_to_send_sms')]);
                return response()->json([
                    'errors' => $errors
                ], 405);
            }
        }
        try
        {
            $mail_status = Helpers::get_mail_status('registration_mail_status_user');
            if (config('mail.status') && $request->email && $mail_status == '1') {
                Mail::to($request->email)->send(new \App\Mail\CustomerRegistration($request->f_name . ' ' . $request->l_name));
            }
        }
        catch(\Exception $ex)
        {
            info($ex->getMessage());
        }
        return response()->json(['token' => $token, 'is_phone_verified' => 0, 'phone_verify_end_url' => "api/v1/auth/verify-phone"], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $data = [
            'phone' => $request->phone,
            'password' => $request->password
        ];
        $customer_verification = BusinessSetting::where('key', 'customer_verification')->first()->value;
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('RestaurantCustomerAuth')->accessToken;
            if (!auth()->user()->status) {
                $errors = [];
                array_push($errors, ['code' => 'auth-003', 'message' => translate('messages.your_account_is_blocked')]);
                return response()->json([
                    'errors' => $errors
                ], 403);
            }
            $user = auth()->user();
            if($customer_verification && !auth()->user()->is_phone_verified && env('APP_MODE') != 'demo')
            {

                // $interval_time = BusinessSetting::where('key', 'otp_interval_time')->first();
                // $otp_interval_time= isset($interval_time) ? $interval_time->value : 60;
                $otp_interval_time= 60; //seconds

                $verification_data= DB::table('phone_verifications')->where('phone', $request['phone'])->first();

                if(isset($verification_data) &&  Carbon::parse($verification_data->updated_at)->DiffInSeconds() < $otp_interval_time){

                    $time= $otp_interval_time - Carbon::parse($verification_data->updated_at)->DiffInSeconds();
                    $errors = [];
                    array_push($errors, ['code' => 'otp', 'message' =>  translate('messages.please_try_again_after_').$time.' '.translate('messages.seconds')]);
                    return response()->json([
                        'errors' => $errors
                    ], 405);
                }

                $otp = rand(1000, 9999);
                DB::table('phone_verifications')->updateOrInsert(['phone' => $request['phone']],
                    [
                    'token' => $otp,
                    'otp_hit_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    ]);
                $mail_status = Helpers::get_mail_status('login_otp_mail_status_user');
                if (config('mail.status') && $mail_status == '1') {
                    Mail::to($user['email'])->send(new LoginVerification($otp,$user->f_name));
                }
                $response = SMS_module::send($request['phone'],$otp);
                // $response = 'qq';
                if($response != 'success')
                {
                    $errors = [];
                    array_push($errors, ['code' => 'otp', 'message' => translate('messages.faield_to_send_sms')]);
                    return response()->json([
                        'errors' => $errors
                    ], 405);
                }

            }
            if($user->ref_code == null && isset($user->id)){
                $ref_code = Helpers::generate_referer_code($user);
                DB::table('users')->where('phone', $user->phone)->update(['ref_code' => $ref_code]);
            }
            return response()->json(['token' => $token, 'is_phone_verified' => auth()->user()->is_phone_verified], 200);
        } else {
            $errors = [];
            array_push($errors, ['code' => 'auth-001', 'message' => translate('messages.Unauthorized')]);
            return response()->json([
                'errors' => $errors
            ], 401);
        }
    }
}
