<?php

namespace App\Http\Controllers\Api\V1\Vendor;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;

class ReportController extends Controller
{
    public function expense_report(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'limit' => 'required',
            'offset' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);

        $key = explode(' ', $request['search']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $limit = $request['limite']??25;
        $offset = $request['offset']??1;
        $from = $request->from;
        $to = $request->to;
        $store_id = $request->vendor->stores[0]->id;

        $expense = Expense::where('created_by','vendor')->where('store_id',$store_id)
            ->when(isset($from) &&  isset($to) ,function($query) use($from,$to){
                $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:29']);
            })->when(isset($key), function($query) use($key) {
                $query->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('order_id', 'like', "%{$value}%");
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $offset);
            $data = [
                'total_size' => $expense->total(),
                'limit' => $limit,
                'offset' => $offset,
                'expense' => $expense->items()
            ];
            return response()->json($data,200);
    }


}
