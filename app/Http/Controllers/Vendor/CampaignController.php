<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Campaign;
use App\Models\ItemCampaign;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Store;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;


class CampaignController extends Controller
{
    function list()
    {
        $campaigns=Campaign::with('stores')->running()->latest()->module(Helpers::get_store_data()->module_id)->paginate(config('default_pagination'));
        return view('vendor-views.campaign.list',compact('campaigns'));
    }

    function itemlist()
    {
        $campaigns=ItemCampaign::where('store_id', Helpers::get_store_id())->latest()->paginate(config('default_pagination'));
        return view('vendor-views.campaign.item_list',compact('campaigns'));
    }

    public function remove_store(Campaign $campaign, $store)
    {
        $campaign->stores()->detach($store);
        $campaign->save();
        Toastr::success(translate('messages.store_remove_from_campaign'));
        return back();
    }
    public function addstore(Campaign $campaign, $store_id)
    {
        $campaign->stores()->attach($store_id,['campaign_status' => 'pending']);
        $campaign->save();
        $store = Store::find($store_id);
        try
        {
            $admin= Admin::where('role_id', 1)->first();
            $mail_status = Helpers::get_mail_status('campaign_request_mail_status_admin');
            if(config('mail.status') && $mail_status == '1') {
                Mail::to($admin->email)->send(new \App\Mail\CampaignRequestMail($store->name));
            }
            $mail_status = Helpers::get_mail_status('campaign_request_mail_status_store');
            if(config('mail.status') && $mail_status == '1') {
                Mail::to($store->vendor->email)->send(new \App\Mail\VendorCampaignRequestMail($store->name,'pending'));
            }
        }
        catch(\Exception $e)
        {
            info($e->getMessage());
        }
        Toastr::success(translate('messages.store_added_to_campaign'));
        return back();
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $campaigns=Campaign::
        where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('title', 'like', "%{$value}%");
            }
        })
        ->module(Helpers::get_store_data()->module_id)
        ->limit(50)->get();
        return response()->json([
            'view'=>view('vendor-views.campaign.partials._table',compact('campaigns'))->render()
        ]);
    }

    public function searchItem(Request $request){
        $key = explode(' ', $request['search']);
        $campaigns=ItemCampaign::where('store_id', Helpers::get_store_id())->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('title', 'like', "%{$value}%");
            }
        })->limit(50)->get();
        return response()->json([
            'view'=>view('vendor-views.campaign.partials._item_table',compact('campaigns'))->render(),
            'count'=>$campaigns->count(),
        ]);
    }

}
