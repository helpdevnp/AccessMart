<table id="columnSearchDatatable"
        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
        data-hs-datatables-options='{
        "order": [],
        "orderCellsTop": true,

        "entries": "#datatableEntries",
        "isResponsive": false,
        "isShowPaging": false,
        "pagination": "datatablePagination"
        }'>
    <thead class="thead-light">
    <tr>
        <th>{{translate('messages.#')}}</th>
        <th>{{translate('messages.title')}}</th>
        <th>{{translate('messages.code')}}</th>
        <th>{{translate('messages.min')}} {{translate('messages.purchase')}}</th>
        <th>{{translate('messages.max')}} {{translate('messages.discount')}}</th>
        <th>{{translate('messages.discount')}}</th>
        <th>{{translate('messages.discount')}} {{translate('messages.type')}}</th>
        <th>{{translate('messages.start')}} {{translate('messages.date')}}</th>
        <th>{{translate('messages.expire')}} {{translate('messages.date')}}</th>
        <th>{{translate('messages.status')}}</th>
        <th>{{translate('messages.action')}}</th>
    </tr>
    </thead>

    <tbody id="set-rows">
    @foreach($coupons as $key=>$coupon)
        <tr>
            <td>{{$key+1}}</td>
            <td>
            <span class="d-block font-size-sm text-body">
                {{Str::limit($coupon['title'],15,'...')}}
            </span>
            </td>
            <td>{{$coupon['code']}}</td>
            <td>{{\App\CentralLogics\Helpers::format_currency($coupon['min_purchase'])}}</td>
            <td>{{\App\CentralLogics\Helpers::format_currency($coupon['max_discount'])}}</td>
            <td>{{$coupon['discount']}}</td>
            <td>{{$coupon['discount_type']}}</td>
            <td>{{$coupon['start_date']}}</td>
            <td>{{$coupon['expire_date']}}</td>
            <td>
                <label class="toggle-switch toggle-switch-sm" for="couponCheckbox{{$coupon->id}}">
                    <input type="checkbox" onclick="location.href='{{route('admin.coupon.status',[$coupon['id'],$coupon->status?0:1])}}'" class="toggle-switch-input" id="couponCheckbox{{$coupon->id}}" {{$coupon->status?'checked':''}}>
                    <span class="toggle-switch-label">
                        <span class="toggle-switch-indicator"></span>
                    </span>
                </label>
            </td>
            <td>
                <a class="btn btn-sm btn-white" href="{{route('admin.coupon.update',[$coupon['id']])}}"title="{{translate('messages.edit')}} {{translate('messages.coupon')}}"><i class="tio-edit"></i>
                </a>
                <a class="btn btn-sm btn-white" href="javascript:" onclick="form_alert('coupon-{{$coupon['id']}}','{{ translate('Want to delete this coupon ?') }}')" title="{{translate('messages.delete')}} {{translate('messages.coupon')}}"><i class="tio-delete-outlined"></i>
                </a>
                <form action="{{route('admin.coupon.delete',[$coupon['id']])}}"
                            method="post" id="coupon-{{$coupon['id']}}">
                        @csrf @method('delete')
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
<table>
    <tfoot>

    </tfoot>
</table>
