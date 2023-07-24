<?php

namespace App\Http\Controllers\api\v1\auth;

use App\CentralLogics\CustomerLogic;
use Carbon\CarbonInterval;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\SMS_module;
use App\Models\BusinessSetting;
use Illuminate\Support\Carbon;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

class SocialAuthController extends Controller
{
    public function social_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'unique_id' => 'required',
            'email' => 'required_if:medium,google,facebook|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'medium' => 'required|in:google,facebook,apple',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $client = new Client();
        $token = $request['token'];
        $email = $request['email'];
        $unique_id = $request['unique_id'];
        try {
            if ($request['medium'] == 'google') {
                $res = $client->request('GET', 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=' . $token);
                $data = json_decode($res->getBody()->getContents(), true);
            } elseif ($request['medium'] == 'facebook') {
                $res = $client->request('GET', 'https://graph.facebook.com/' . $unique_id . '?access_token=' . $token . '&&fields=name,email');
                $data = json_decode($res->getBody()->getContents(), true);
            } elseif ($request['medium'] == 'apple') {
                $user = User::where('temp_token', $unique_id)->first();
                $data = [
                    'email' => $user->email
                ];
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'wrong credential.','message'=>$e->getMessage()],403);
        }
        if($request['medium'] == 'apple'){
            $fast_name = implode('@', explode('@', $data['email'], -1));
            $last_name = '';

            $user = User::where('email', $data['email'])->where('phone', $request->phone)->where('temp_token', $unique_id)->first();
            if (!isset($user)) {
                //Check Exists Ref Code
                $check_duplicate_ref = WalletTransaction::where('reference', $request->phone)->first();

                //Check Exists Ref Code Condition
                if ($check_duplicate_ref) {
                    return response()->json(['errors'=>['code'=>'ref_code','message'=>'Referral code already used']]);
                } else {
                    $user = User::where('email', $data['email'])->where('temp_token', $unique_id)->first();
                    $user->phone = $request->phone;
                    $user->password = bcrypt($request->phone);

                    $user->ref_code = Helpers::generate_referer_code();
                    $user->save();

                    //Save point to refeer
                    if ($request->ref_code) {
                        $checkRefCode = $request->ref_code;
                        $referar_user = User::where('ref_code', '=', $checkRefCode)->first();
                        $ref_status = BusinessSetting::where('key', 'ref_earning_status')->first()->value;
                        if ($ref_status != '1') {
                            $errors = [];
                            array_push($errors, ['code' => 'ref_code', 'message' => translate('messages.referer_disable')]);
                            return response()->json([
                                'errors' => $errors
                            ], 405);
                        }

                        if (!$referar_user) {
                            $errors = [];
                            array_push($errors, ['code' => 'ref_code', 'message' => translate('messages.referer_code_not_found')]);
                            return response()->json([
                                'errors' => $errors
                            ], 405);
                        }

                        $user->ref_by =$referar_user->id;
                        $user->save();

                        // $ref_code_exchange_amt = BusinessSetting::where('key', 'ref_earning_exchange_rate')->first()->value;

                        // $refer_wallet_transaction = CustomerLogic::create_wallet_transaction($referar_user->id, $ref_code_exchange_amt, 'referrer', $user->phone);

                        // try {
                        //     if (config('mail.status')) {
                        //         Mail::to($referar_user->email)->send(new \App\Mail\AddFundToWallet($refer_wallet_transaction));
                        //     }
                        // } catch (\Exception $ex) {
                        //     info($ex->getMessage());
                        // }
                    }
                }
            } else {
                return response()->json([
                    'errors' => [
                        ['code' => 'auth-004', 'message' => translate('messages.email_already_exists')]
                    ]
                ], 403);
            }

            $data = [
                'phone' => $user->phone,
                'password' => $user->phone
            ];
            $customer_verification = BusinessSetting::where('key','customer_verification')->first()->value;
            if (auth()->attempt($data)) {
                $token = auth()->user()->createToken('RestaurantCustomerAuth')->accessToken;
                if(!auth()->user()->status)
                {
                    $errors = [];
                    array_push($errors, ['code' => 'auth-003', 'message' => translate('messages.your_account_is_blocked')]);
                    return response()->json([
                        'errors' => $errors
                    ], 403);
                }
                if($customer_verification && !auth()->user()->is_phone_verified && env('APP_MODE') != 'demo')
                {
                    // $interval_time = BusinessSetting::where('key', 'otp_interval_time')->first();
                    // $otp_interval_time= isset($interval_time) ? $interval_time->value : 20;
                    $otp_interval_time= 60; //seconds
                    $phone_verification_data= DB::table('phone_verifications')->where('phone', $request['phone'])->first();
                    if(isset($phone_verification_data) &&  Carbon::parse($phone_verification_data->updated_at)->DiffInSeconds() < $otp_interval_time){
                        $time= $otp_interval_time - Carbon::parse($phone_verification_data->updated_at)->DiffInSeconds();
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
                        'created_at' => now(),
                        'updated_at' => now(),
                        ]);
                    $response = SMS_module::send($request['phone'],$otp);
                    if($response != 'success')
                    {

                        $errors = [];
                        array_push($errors, ['code' => 'otp', 'message' => translate('messages.faield_to_send_sms')]);
                        return response()->json([
                            'errors' => $errors
                        ], 403);
                    }
                }
                return response()->json(['token' => $token, 'is_phone_verified'=>auth()->user()->is_phone_verified], 200);
            } else {
                $errors = [];
                array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.']);
                return response()->json([
                    'errors' => $errors
                ], 401);
            }
        }
        if ($request['medium'] != 'apple' && strcmp($email, $data['email']) === 0) {
            $name = explode(' ', $data['name']);
            if (count($name) > 1) {
                $fast_name = implode(" ", array_slice($name, 0, -1));
                $last_name = end($name);
            } else {
                $fast_name = implode(" ", $name);
                $last_name = '';
            }
            $user = User::where('email', $email)->first();
            if (isset($user) == false) {
                //Check Exists Ref Code
                $check_duplicate_ref = WalletTransaction::where('reference', $request->phone)->first();

                //Check Exists Ref Code Condition
                if ($check_duplicate_ref) {
                    return response()->json(['errors'=>['code'=>'ref_code','message'=>'Referral code already used']]);
                } else {
                    if(!isset($data['id']) && !isset($data['kid'])){
                        return response()->json(['error' => 'wrong credential.'],403);
                    }
                    $pk = isset($data['id'])?$data['id']:$data['kid'];
                    $user = User::create([
                        'f_name' => $fast_name,
                        'l_name' => $last_name,
                        'email' => $email,
                        'phone' => $request->phone,
                        'password' => bcrypt($pk),
                        'login_medium' => $request['medium'],
                        'social_id' => $pk,
                    ]);

                    $user->ref_code = Helpers::generate_referer_code();
                    $user->save();

                    //Save point to refeer
                    if ($request->ref_code) {
                        $checkRefCode = $request->ref_code;
                        $referar_user = User::where('ref_code', '=', $checkRefCode)->first();
                        $ref_status = BusinessSetting::where('key', 'ref_earning_status')->first()->value;
                        if ($ref_status != '1') {
                            $errors = [];
                            array_push($errors, ['code' => 'ref_code', 'message' => translate('messages.referer_disable')]);
                            return response()->json([
                                'errors' => $errors
                            ], 405);
                        }

                        if (!$referar_user) {
                            $errors = [];
                            array_push($errors, ['code' => 'ref_code', 'message' => translate('messages.referer_code_not_found')]);
                            return response()->json([
                                'errors' => $errors
                            ], 405);
                        }

                        $user->ref_by =$referar_user->id;
                        $user->save();

                        // $ref_code_exchange_amt = BusinessSetting::where('key', 'ref_earning_exchange_rate')->first()->value;

                        // $refer_wallet_transaction = CustomerLogic::create_wallet_transaction($referar_user->id, $ref_code_exchange_amt, 'referrer', $user->phone);

                        // try {
                        //     if (config('mail.status')) {
                        //         Mail::to($referar_user->email)->send(new \App\Mail\AddFundToWallet($refer_wallet_transaction));
                        //     }
                        // } catch (\Exception $ex) {
                        //     info($ex->getMessage());
                        // }
                    }
                }
            } else {
                return response()->json([
                    'errors' => [
                        ['code' => 'auth-004', 'message' => translate('messages.email_already_exists')]
                    ]
                ], 403);
            }

            $data = [
                'phone' => $user->phone,
                'password' => $user->social_id
            ];
            $customer_verification = BusinessSetting::where('key','customer_verification')->first()->value;
            if (auth()->attempt($data)) {
                $token = auth()->user()->createToken('RestaurantCustomerAuth')->accessToken;
                if(!auth()->user()->status)
                {
                    $errors = [];
                    array_push($errors, ['code' => 'auth-003', 'message' => translate('messages.your_account_is_blocked')]);
                    return response()->json([
                        'errors' => $errors
                    ], 403);
                }
                if($customer_verification && !auth()->user()->is_phone_verified && env('APP_MODE') != 'demo')
                {
                    // $interval_time = BusinessSetting::where('key', 'otp_interval_time')->first();
                    // $otp_interval_time= isset($interval_time) ? $interval_time->value : 20;
                    $otp_interval_time= 60; //seconds
                    $phone_verification_data= DB::table('phone_verifications')->where('phone', $request['phone'])->first();
                    if(isset($phone_verification_data) &&  Carbon::parse($phone_verification_data->updated_at)->DiffInSeconds() < $otp_interval_time){
                        $time= $otp_interval_time - Carbon::parse($phone_verification_data->updated_at)->DiffInSeconds();
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
                        'created_at' => now(),
                        'updated_at' => now(),
                        ]);
                    $response = SMS_module::send($request['phone'],$otp);
                    if($response != 'success')
                    {

                        $errors = [];
                        array_push($errors, ['code' => 'otp', 'message' => translate('messages.faield_to_send_sms')]);
                        return response()->json([
                            'errors' => $errors
                        ], 403);
                    }
                }
                return response()->json(['token' => $token, 'is_phone_verified'=>auth()->user()->is_phone_verified], 200);
            } else {
                $errors = [];
                array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.']);
                return response()->json([
                    'errors' => $errors
                ], 401);
            }


        }

        return response()->json(['error' => translate('messages.email_does_not_match')]);
    }


    public function social_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'unique_id' => 'required',
            'email' => 'required_if:medium,google,facebook',
            'medium' => 'required|in:google,facebook,apple',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $client = new Client();
        $token = $request['token'];
        $email = $request['email'];
        $unique_id = $request['unique_id'];
        try {
            if ($request['medium'] == 'google') {
                $res = $client->request('GET', 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=' . $token);
                $data = json_decode($res->getBody()->getContents(), true);
            } elseif ($request['medium'] == 'facebook') {
                $res = $client->request('GET', 'https://graph.facebook.com/' . $unique_id . '?access_token=' . $token . '&&fields=name,email');
                $data = json_decode($res->getBody()->getContents(), true);
            } elseif ($request['medium'] == 'apple') {
                $apple_login=\App\Models\BusinessSetting::where(['key'=>'apple_login'])->first();
                if($apple_login){
                    $apple_login = json_decode($apple_login->value)[0];
                }
                $teamId = $apple_login->team_id;
                $keyId = $apple_login->key_id;
                $sub = $apple_login->client_id;
                $aud = 'https://appleid.apple.com';
                $iat = strtotime('now');
                $exp = strtotime('+60days');
                $keyContent = file_get_contents('storage/app/public/apple-login/'.$apple_login->service_file);
            
                $token = JWT::encode([
                    'iss' => $teamId,
                    'iat' => $iat,
                    'exp' => $exp,
                    'aud' => $aud,
                    'sub' => $sub,
                ], $keyContent, 'ES256', $keyId);
                $redirect_uri = $apple_login->redirect_url??'www.example.com/apple-callback';
                $res = Http::asForm()->post('https://appleid.apple.com/auth/token', [
                    'grant_type' => 'authorization_code',
                    'code' => $unique_id,
                    'redirect_uri' => $redirect_uri,
                    'client_id' => $sub,
                    'client_secret' => $token,
                ]);
                
            
                $claims = explode('.', $res['id_token'])[1];
                $data = json_decode(base64_decode($claims),true);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'wrong credential.','message'=>$e->getMessage()],403);
        }
        if(!isset($claims)){
            
            if (strcmp($email, $data['email']) != 0 || (!isset($data['id']) && !isset($data['kid']))) {
                return response()->json(['error' => translate('messages.email_does_not_match')],403);
            }
        }

        $user = User::where('email', $data['email'])->first();
        
        if($request['medium'] == 'apple'){
                try {
                    if(isset($user) == false )
                    {
                        $user = new User();
                    }
                    $user->f_name = implode('@', explode('@', $data['email'], -1));
                    $user->l_name = '';
                    $user->email = $data['email'];
                    $user->login_medium = $request['medium'];
                    $user->temp_token = $unique_id;
                    $user->save();
                } catch (\Throwable $e) {
                    return response()->json(['error' => 'wrong credential.','message'=>$e->getMessage()],403);
                }
            }

        if(isset($user) == false )
        {
            return response()->json(['token' => null, 'is_phone_verified'=>0], 200);
        }

        if($request['medium'] == 'apple' && $user->phone == null)
        {
            return response()->json(['token' => null, 'is_phone_verified'=>0], 200);
        }

        $customer_verification = BusinessSetting::where('key','customer_verification')->first()->value;
        if (auth()->loginUsingId($user->id)) {
            $token = auth()->user()->createToken('RestaurantCustomerAuth')->accessToken;
            if(!auth()->user()->status)
            {
                $errors = [];
                array_push($errors, ['code' => 'auth-003', 'message' => translate('messages.your_account_is_blocked')]);
                return response()->json([
                    'errors' => $errors
                ], 403);
            }
            if($customer_verification && !auth()->user()->is_phone_verified && env('APP_MODE') != 'demo')
            {
                // $interval_time = BusinessSetting::where('key', 'otp_interval_time')->first();
                // $otp_interval_time= isset($interval_time) ? $interval_time->value : 20;
                $otp_interval_time= 60; //seconds
                $phone_verification_data= DB::table('phone_verifications')->where('phone', $request['phone'])->first();
                if(isset($phone_verification_data) &&  Carbon::parse($phone_verification_data->updated_at)->DiffInSeconds() < $otp_interval_time){
                    $time= $otp_interval_time - Carbon::parse($phone_verification_data->updated_at)->DiffInSeconds();
                    $errors = [];
                    array_push($errors, ['code' => 'otp', 'message' =>  translate('messages.please_try_again_after_').$time.' '.translate('messages.seconds')]);
                    return response()->json([
                        'errors' => $errors
                    ], 405);
                }
                $otp = rand(1000, 9999);
                DB::table('phone_verifications')->updateOrInsert(['phone' => $user->phone],
                    [
                    'token' => $otp,
                    'otp_hit_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    ]);
                $response = SMS_module::send($user->phone,$otp);
                if($response != 'success')
                {

                    $errors = [];
                    array_push($errors, ['code' => 'otp', 'message' => translate('messages.faield_to_send_sms')]);
                    return response()->json([
                        'errors' => $errors
                    ], 403);
                }
            }
            if($user->ref_code == null && isset($user->id)){
                $ref_code = Helpers::generate_referer_code($user);
                DB::table('users')->where('phone', $user->phone)->update(['ref_code' => $ref_code]);
            }
            return response()->json(['token' => $token, 'is_phone_verified'=>auth()->user()->is_phone_verified, 'phone'=>$user->phone, 'res'=>$res], 200);
        } else {
            $errors = [];
            array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthorized.']);
            return response()->json([
                'errors' => $errors
            ], 401);
        }

        return response()->json([
            'errors'=>[
                ['code'=>'not-found','message' => translate('messages.user_not_found')]
            ]
        ], 404);
    }

}
