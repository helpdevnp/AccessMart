@foreach ($expense as $key => $exp)
    <tr>
        <td scope="row">{{$key+1}}</td>
        <td>
            @if ($exp->order)
                                        
            <div>
                <a
                    href="{{ route('admin.order.details', ['id' => $exp->order->id,'module_id'=>$exp->order->module_id]) }}">{{ $exp['order_id'] }}</a>
            </div>
            @endif
        </td>
        <td>
            {{date('Y-m-d '.config('timeformat'),strtotime($exp->created_at))}}
        </td>
        <td><label class="text-uppercase">{{translate("messages.{$exp['type']}")}}</label></td>
        <td class="text-center">
            @if (isset($exp->order->customer))
            {{ $exp->order->customer->f_name.' '.$exp->order->customer->l_name }}
            @else
            <label class="badge badge-danger">{{translate('messages.invalid')}} {{translate('messages.customer')}} {{translate('messages.data')}}</label>

            @endif
        </td>
        <td class="text-right pr-xl-5">
            <div class="pr-xl-5">
                {{\App\CentralLogics\Helpers::format_currency($exp['amount'])}}
            </div>
        </td>
    </tr>
@endforeach