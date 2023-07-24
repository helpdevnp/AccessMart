@php($store_id = \App\CentralLogics\Helpers::get_store_id())
@foreach($campaigns as $key=>$campaign)
<tr>
    <td>{{$key+1}}</td>
    <td>
        <span class="d-block font-size-sm text-body">
            {{Str::limit($campaign['title'],25,'...')}}
        </span>
    </td>
    <td>
        <div class="overflow-hidden">
            <img class="img--vertical max--200 mw--200" src="{{asset('storage/app/public/campaign')}}/{{$campaign['image']}}"onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
        </div>
    </td>
    <td>
        <span class="bg-gradient-light text-dark">{{$campaign->start_date?$campaign->start_date->format('d M, Y'). ' - ' .$campaign->end_date->format('d M, Y'): 'N/A'}}</span>
    </td>
    <td>
        <span class="bg-gradient-light text-dark">{{$campaign->start_time?date(config('timeformat'),strtotime($campaign->start_time)). ' - ' .date(config('timeformat'),strtotime($campaign->end_time)): 'N/A'}}</span>
    </td>
    <?php
    $store_ids = [];
    $store_status = '--';
    foreach($campaign->stores as $store)
        {
            if ($store->id == $store_id && $store->pivot) {
                $store_status = $store->pivot->campaign_status;
            }
            $store_ids[] = $store->id;
        }
     ?>
    <td class="text-capitalize">
        @if ($store_status == 'pending')
            <span class="badge badge-soft-info">
                {{ translate('messages.not_approved') }}
            </span>
        @elseif($store_status == 'confirmed')
            <span class="badge badge-soft-success">
                {{ translate('messages.confirmed') }}
            </span>
        @elseif($store_status == 'rejected')
            <span class="badge badge-soft-danger">
                {{ translate('messages.rejected') }}
            </span>
        @else
            <span class="badge badge-soft-info">
                {{ translate(str_replace('_', ' ', $store_status)) }}
            </span>
        @endif

    </td>
    <td class="text-center">
        @if ($store_status == 'rejected')
            <span class="badge badge-pill badge-danger">{{ translate('Rejected') }}</span>
        @else
            @if(in_array($store_id,$store_ids))
            <!-- <button type="button" onclick="location.href='{{route('vendor.campaign.remove-store',[$campaign['id'],$store_id])}}'" title="You are already joined. Click to out from the campaign." class="btn btn-outline-danger">Out</button> -->
            <span type="button" onclick="form_alert('campaign-{{$campaign['id']}}','{{translate('messages.alert_store_out_from_campaign')}}')" title="You are already joined. Click to out from the campaign." class="badge btn--danger text-white">{{translate('messages.leave')}}</span>
            <form action="{{route('vendor.campaign.remove-store',[$campaign['id'],$store_id])}}"
                    method="GET" id="campaign-{{$campaign['id']}}">
                @csrf
            </form>
            @else
            <span type="button" class="badge btn--primary text-white" onclick="form_alert('campaign-{{$campaign['id']}}','{{translate('messages.alert_store_join_campaign')}}')" title="Click to join the campaign">{{translate('messages.join')}}</span>
            <form action="{{route('vendor.campaign.add-store',[$campaign['id'],$store_id])}}"
                    method="GET" id="campaign-{{$campaign['id']}}">
                @csrf
            </form>
            @endif
        @endif
    </td>
</tr>
@endforeach
