<?php

namespace App\Http\Controllers\Vendor;

use App\Models\StoreWallet;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;

class WalletController extends Controller
{
    public function index()
    {
        $withdraw_req = WithdrawRequest::with(['vendor'])->where('vendor_id', Helpers::get_vendor_id())->latest()->paginate(config('default_pagination'));
        return view('vendor-views.wallet.index', compact('withdraw_req'));
    }
    public function w_request(Request $request)
    {
        $w = StoreWallet::where('vendor_id', Helpers::get_vendor_id())->first();
        if ($w->balance >= $request['amount'] && $request['amount'] > .01) {
            $data = [
                'vendor_id' => Helpers::get_vendor_id(),
                'amount' => $request['amount'],
                'transaction_note' => null,
                'approved' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];
            DB::table('withdraw_requests')->insert($data);
            StoreWallet::where('vendor_id', Helpers::get_vendor_id())->increment('pending_withdraw', $request['amount']);
            try
            {
                $admin= Admin::where('role_id', 1)->first();
                $mail_status = Helpers::get_mail_status('withdraw_request_mail_status_admin');
                if(config('mail.status') && $mail_status == '1') {
                    $wallet_transaction = WithdrawRequest::where('vendor_id',Helpers::get_vendor_id())->latest()->first();
                    Mail::to($admin['email'])->send(new \App\Mail\WithdrawRequestMail('pending',$wallet_transaction));
                }
            }
            catch(\Exception $e)
            {
                info($e->getMessage());
            }
            Toastr::success('Withdraw request has been sent.');
            return redirect()->back();
        }

        Toastr::error('invalid request.!');
        return redirect()->back();
    }

    public function close_request($id)
    {
        $wr = WithdrawRequest::find($id);
        if ($wr->approved == 0) {
            StoreWallet::where('vendor_id', Helpers::get_vendor_id())->decrement('pending_withdraw', $wr['amount']);
        }
        $wr->delete();
        Toastr::success('request closed!');
        return back();
    }
}
