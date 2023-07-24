<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\Models\Translation;

class RestaurantController extends Controller
{
    public function view()
    {
        $shop = Helpers::get_store_data();
        return view('vendor-views.shop.shopInfo', compact('shop'));
    }

    public function edit()
    {
        $store = Helpers::get_store_data();
        $shop = Store::withoutGlobalScope('translate')->findOrFail($store['id']);
        return view('vendor-views.shop.edit', compact('shop'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'name.0' => 'required',
            'address' => 'nullable|max:1000',
            'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:stores,phone,'.Helpers::get_store_id(),
        ], [
            'f_name.required' => translate('messages.first_name_is_required'),
            'name.0.required'=>translate('default_name_is_required'),
        ]);
        $shop = Store::findOrFail(Helpers::get_store_id());
        $shop->name = $request->name[array_search('default', $request->lang)];
        $shop->address = $request->address[array_search('default', $request->lang)];
        $shop->phone = $request->contact;

        $shop->logo = $request->has('image') ? Helpers::update('store/', $shop->logo, 'png', $request->file('image')) : $shop->logo;

        $shop->cover_photo = $request->has('photo') ? Helpers::update('store/cover/', $shop->cover_photo, 'png', $request->file('photo')) : $shop->cover_photo;

        $shop->save();

        $default_lang = str_replace('_', '-', app()->getLocale());
        foreach($request->lang as $index=>$key)
        {
            if($default_lang == $key && !($request->name[$index])){
                if ($key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Models\Store',
                            'translationable_id' => $shop->id,
                            'locale' => $key,
                            'key' => 'name'
                        ],
                        ['value' => $shop->name]
                    );
                }
            }else{

                if ($request->name[$index] && $key != 'default') {
                    Translation::updateOrInsert(
                        ['translationable_type'  => 'App\Models\Store',
                            'translationable_id'    => $shop->id,
                            'locale'                => $key,
                            'key'                   => 'name'],
                        ['value'                 => $request->name[$index]]
                    );
                }
            }
            if($default_lang == $key && !($request->address[$index])){
                if ($key != 'default') {
                    Translation::updateOrInsert(
                        [
                            'translationable_type' => 'App\Models\Store',
                            'translationable_id' => $shop->id,
                            'locale' => $key,
                            'key' => 'address'
                        ],
                        ['value' => $shop->address]
                    );
                }
            }else{

                if ($request->address[$index] && $key != 'default') {
                    Translation::updateOrInsert(
                        ['translationable_type'  => 'App\Models\Store',
                            'translationable_id'    => $shop->id,
                            'locale'                => $key,
                            'key'                   => 'address'],
                        ['value'                 => $request->address[$index]]
                    );
                }
            }
        }

        if($shop->vendor->userinfo) {
            $userinfo = $shop->vendor->userinfo;
            $userinfo->f_name = $shop->name;
            $userinfo->image = $shop->logo;
            $userinfo->save();
        }

        Toastr::success(translate('messages.store_data_updated'));
        return redirect()->route('vendor.shop.view');
    }

}
