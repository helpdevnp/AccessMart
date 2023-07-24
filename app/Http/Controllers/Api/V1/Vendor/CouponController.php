<?php

namespace App\Http\Controllers\Api\V1\Vendor;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function list(Request $request){
        $validator = Validator::make($request->all(), [
            'limit' => 'required',
            'offset' => 'required',
        ]);
        $store_id = $request->vendor->stores[0]->id;
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $limit = $request['limit']??25;
        $offset = $request['offset']??1;
        $storage = [];
        $coupons = Coupon::latest()->where('created_by', 'vendor')->where('store_id',$store_id)
        ->paginate($limit, ['*'], 'page', $offset);

            foreach($coupons->items() as $item){
                $item['data'] = json_decode($item['data'],true);
                $item['customer_id'] = json_decode($item['customer_id'],true);
                array_push($storage, $item);
            }

        return response()->json($storage,200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons|max:100',
            // 'title' => 'required|max:191',
            'start_date' => 'required',
            'expire_date' => 'required',
            'coupon_type' => 'required|in:free_delivery,default',
            'discount' => 'required_if:coupon_type,default'
        ]);
        $customer_id  = $request->customer_ids ?? ['all'];
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $store_id = $request->vendor->stores[0]->id;
        
        $data = json_decode($request->translations, true);
        
        if (count($data) < 1) {
            $validator->getMessageBag()->add('translations', translate('messages.Title in english is required'));
        }

        $coupon_data = "";
        $coupon = new Coupon();
        $coupon->title = $data[0]['value'];
        $coupon->code = $request->code;
        $coupon->limit = $request->coupon_type=='first_order'?1:$request->limit;
        $coupon->coupon_type = $request->coupon_type;
        $coupon->start_date = $request->start_date;
        $coupon->expire_date = $request->expire_date;
        $coupon->min_purchase = $request->min_purchase != null ? $request->min_purchase : 0;
        $coupon->max_discount = $request->max_discount != null ? $request->max_discount : 0;
        $coupon->discount = $request->discount_type == 'amount' ? $request->discount : $request['discount'];
        $coupon->discount_type = $request->discount_type??'';
        $coupon->status = 1;
        $coupon->created_by = 'vendor';
        $coupon->data = json_encode($coupon_data);
        $coupon->store_id =$store_id;
        $coupon->customer_id = json_encode($customer_id);
        $coupon->module_id = $request->vendor->stores[0]->module_id;
        $coupon->save();
       
        foreach ($data as $key=>$i) {
            $data[$key]['translationable_type'] = 'App\Models\Coupon';
            $data[$key]['translationable_id'] = $coupon->id;
        }
        Translation::insert($data);

        return response()->json(['message' => translate('messages.coupon_added_successfully')], 200);

    }

    public function view(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $coupon = Coupon::find($request->coupon_id);
        $coupon['data'] = json_decode($coupon['data'],true);
        $coupon['customer_id'] = json_decode($coupon['customer_id'],true);
        return response()->json([$coupon],200);
    }

    public function view_without_translate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $coupon = Coupon::withoutGlobalScope('translate')->find($request->coupon_id);
        $coupon['data'] = json_decode($coupon['data'],true);
        $coupon['customer_id'] = json_decode($coupon['customer_id'],true);
        return response()->json([$coupon],200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id'=> 'required',
            'code' => 'required|max:100|unique:coupons,code,'.$request->coupon_id,
            // 'title' => 'required|max:191',
            'start_date' => 'required',
            'expire_date' => 'required',
            'discount' => 'required_if:coupon_type,default',
            'coupon_type' => 'required|in:free_delivery,default',

        ]);
        $data = json_decode($request->translations, true);

        if (count($data) < 1) {
            $validator->getMessageBag()->add('translations', translate('messages.Title in english is required'));
        }
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $store_id = $request->vendor->stores[0]->id;
        $customer_id  = $request->customer_ids ?? ['all'];

        $coupon = Coupon::where(['id' => $request->coupon_id])->where('created_by', 'vendor' )->where('store_id',$store_id)->first();

        $coupon->title = $data[0]['value'];
        $coupon->code = $request->code;
        $coupon->limit = $request->coupon_type=='first_order'?1:$request->limit;
        $coupon->coupon_type = $request->coupon_type;
        $coupon->start_date = $request->start_date;
        $coupon->expire_date = $request->expire_date;
        $coupon->min_purchase = $request->min_purchase != null ? $request->min_purchase : 0;
        $coupon->max_discount = $request->max_discount != null ? $request->max_discount : 0;
        $coupon->discount = $request->discount_type == 'amount' ? $request->discount : $request['discount'];
        $coupon->discount_type = $request->discount_type ?? '';
        $coupon->customer_id = json_encode($customer_id);
        $coupon->save();
      
        foreach ($data as $key=>$i) {
            
            Translation::updateOrInsert(
                ['translationable_type'  => 'App\Models\Coupon',
                    'translationable_id'    => $coupon->id,
                    'locale'                => $i['locale'],
                    'key'                   => 'title'],
                ['value'                 => $i['value']]
            );
        }

        return response()->json(['message' => translate('messages.coupon_updated_successfully')], 200);
    }

    public function status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id'=> 'required',
            'status'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $store_id = $request->vendor->stores[0]->id;

        $coupon = Coupon::where(['id' => $request->coupon_id])->where('created_by', 'vendor' )->where('store_id',$store_id)->first();

        $coupon->status = $request->status;
        $coupon->save();
        return response()->json(['message' => translate('messages.coupon_status_updated')], 200);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $store_id = $request->vendor->stores[0]->id;

        $coupon = Coupon::where(['id' => $request->coupon_id])->where('created_by', 'vendor' )->where('store_id',$store_id)->first();
        $coupon->delete();
        return response()->json(['message' => translate('messages.coupon_deleted_successfully')], 200);

    }

    public function search(Request $request){

        $validator = Validator::make($request->all(), [
            'search' => 'required',
            'limit' => 'required',
            'offset' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $store_id = $request->vendor->stores[0]->id;

        $limit = $request['limit']??25;
        $offset = $request['offset']??1;

        $key = explode(' ', $request['search']);
        $coupons=Coupon::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('title', 'like', "%{$value}%")
                ->orWhere('code', 'like', "%{$value}%");
            }
        })->where('created_by', 'vendor' )->where('store_id',$store_id)
        ->paginate($limit, ['*'], 'page', $offset);
        $data = [
            'total_size' => $coupons->total(),
            'limit' => $limit,
            'offset' => $offset,
            'coupons' => $coupons->items()
        ];
        return response()->json([$data],200);
    }

}
