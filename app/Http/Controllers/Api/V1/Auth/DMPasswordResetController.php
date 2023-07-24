<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Carbon\CarbonInterval;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use Illuminate\Support\Carbon;
use App\Models\BusinessSetting;
use App\CentralLogics\SMS_module;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class DMPasswordResetController extends Controller
{
    public function reset_password_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $deliveryman = DeliveryMan::Where(['phone' => $request['phone']])->first();

        if (isset($deliveryman)) {
            if(env('APP_MODE') =='demo')
            {
                return response()->json(['message' => translate('messages.otp_sent_successfull')], 200);
            }

            // $interval_time = BusinessSetting::where('key', 'otp_interval_time')->first();
            // $otp_interval_time= isset($interval_time) ? $interval_time->value : 20;
            $otp_interval_time= 60; //seconds
            $verification_data= DB::table('password_resets')->where('email', $deliveryman['email'])->first();
            if(isset($verification_data) &&  Carbon::parse($verification_data->created_at)->DiffInSeconds() < $otp_interval_time){
                $time= $otp_interval_time - Carbon::parse($verification_data->created_at)->DiffInSeconds();
                $errors = [];
                array_push($errors, ['code' => 'otp', 'message' =>  translate('messages.please_try_again_after_').$time.' '.translate('messages.seconds')]);
                return response()->json([
                    'errors' => $errors
                ], 405);
            }

            $token = rand(1000,9999);
            DB::table('password_resets')->updateOrInsert(['email' => $deliveryman['email']],
            [
                'token' => $token,
                'created_at' => now(),
            ]);
            $mail_status = Helpers::get_mail_status('forget_password_mail_status_dm');
            if (config('mail.status') && $mail_status == '1') {
                Mail::to($deliveryman['email'])->send(new \App\Mail\DmPasswordResetMail($token,$deliveryman['f_name']));
            }
            $response = SMS_module::send($request['phone'],$token);
            if($response == 'success')
            {
                return response()->json(['message' => translate('messages.otp_sent_successfull')], 200);
            }
            else
            {
                $errors = [];
                array_push($errors, ['code' => 'otp', 'message' => translate('messages.failed_to_send_sms')]);
                return response()->json([
                    'errors' => $errors
                ], 405);
            }
        }
        $errors = [];
        array_push($errors, ['code' => 'not-found', 'message' => 'Phone number not found!']);
        return response()->json(['errors' => $errors], 404);
    }

    public function verify_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'reset_token'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $user=DeliveryMan::where('phone', $request->phone)->first();
        if (!isset($user)) {
            $errors = [];
            array_push($errors, ['code' => 'not-found', 'message' => 'Phone number not found!']);
            return response()->json(['errors' => $errors
            ], 404);
        }
        if(env('APP_MODE')=='demo')
        {
            if($request['reset_token'] == '1234')
            {
                return response()->json(['message'=>"Token found, you can proceed"], 200);
            }
            $errors = [];
            array_push($errors, ['code' => 'reset_token', 'message' => 'Invalid token.']);
            return response()->json(['errors' => $errors
                ], 400);
        }
        $data = DB::table('password_resets')->where(['token' => $request['reset_token'],'email'=>$user->email])->first();
        if (isset($data)) {
            return response()->json(['message'=>"Token found, you can proceed"], 200);
        } else{
            // $otp_hit = BusinessSetting::where('key', 'max_otp_hit')->first();
            // $max_otp_hit =isset($otp_hit) ? $otp_hit->value : 5 ;
            $max_otp_hit = 5;
            // $otp_hit_time = BusinessSetting::where('key', 'max_otp_hit_time')->first();
            // $max_otp_hit_time = isset($otp_hit_time) ? $otp_hit_time->value : 30 ;
            $max_otp_hit_time = 60; // seconds
            $temp_block_time = 600; // seconds
            $verification_data= DB::table('password_resets')->where('email', $user->email)->first();

            if(isset($verification_data)){
                $time= $temp_block_time - Carbon::parse($verification_data->temp_block_time)->DiffInSeconds();

                if(isset($verification_data->temp_block_time ) && Carbon::parse($verification_data->temp_block_time)->DiffInSeconds() <= $temp_block_time){
                    $time= $temp_block_time - Carbon::parse($verification_data->temp_block_time)->DiffInSeconds();

                    $errors = [];
                    array_push($errors, ['code' => 'otp_block_time', 'message' => translate('messages.please_try_again_after_').CarbonInterval::seconds($time)->cascade()->forHumans()
                ]);
                return response()->json([
                    'errors' => $errors
                ], 405);
                }

                if($verification_data->is_temp_blocked == 1 && Carbon::parse($verification_data->created_at)->DiffInSeconds() >= $max_otp_hit_time){
                    DB::table('password_resets')->updateOrInsert(['email' => $user->email],
                        [
                            'otp_hit_count' => 0,
                            'is_temp_blocked' => 0,
                            'temp_block_time' => null,
                            'created_at' => now(),
                        ]);
                    }

                if($verification_data->otp_hit_count >= $max_otp_hit &&  Carbon::parse($verification_data->created_at)->DiffInSeconds() < $max_otp_hit_time &&  $verification_data->is_temp_blocked == 0){

                    DB::table('password_resets')->updateOrInsert(['email' => $user->email],                        [
                        'is_temp_blocked' => 1,
                        'temp_block_time' => now(),
                        'created_at' => now(),
                        ]);
                    $errors = [];
                    array_push($errors, ['code' => 'otp_temp_blocked', 'message' => translate('messages.Too_many_attemps') ]);
                    return response()->json([
                        'errors' => $errors
                    ], 405);
                }
            }

            DB::table('password_resets')->updateOrInsert(['email' => $user->email],
            [
            'otp_hit_count' => DB::raw('otp_hit_count + 1'),
            'created_at' => now(),
            'temp_block_time' => null,
            ]);
        }
        $errors = [];
        array_push($errors, ['code' => 'reset_token', 'message' => 'Invalid token.']);
        return response()->json(['errors' => $errors
            ], 400);
    }

    public function reset_password_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'reset_token'=> 'required',
            'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'confirm_password'=> 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        if(env('APP_MODE')=='demo')
        {
            if($request['reset_token']=="1234")
            {
                DB::table('delivery_men')->where(['phone' => $request['phone']])->update([
                    'password' => bcrypt($request['confirm_password'])
                ]);
                return response()->json(['message' => 'Password changed successfully.'], 200);
            }
            $errors = [];
            array_push($errors, ['code' => 'invalid', 'message' => 'Invalid token.']);
            return response()->json(['errors' => $errors], 400);
        }
        $data = DB::table('password_resets')->where(['token' => $request['reset_token']])->first();
        if (isset($data)) {
            if ($request['password'] == $request['confirm_password']) {
                DB::table('delivery_men')->where(['email' => $data->email])->update([
                    'password' => bcrypt($request['confirm_password'])
                ]);
                DB::table('password_resets')->where(['token' => $request['reset_token']])->delete();
                return response()->json(['message' => 'Password changed successfully.'], 200);
            }
            $errors = [];
            array_push($errors, ['code' => 'mismatch', 'message' => 'Password did,t match!']);
            return response()->json(['errors' => $errors], 401);
        }

        $errors = [];
        array_push($errors, ['code' => 'invalid', 'message' => 'Invalid token.']);
        return response()->json(['errors' => $errors], 400);
    }
}
