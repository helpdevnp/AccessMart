@extends('layouts.admin.app')

@section('title',translate('Campaign view'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-break">{{$campaign->title}}</h1>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Body -->
            <div class="card-body">
                <div class="row align-items-md-center gx-md-5">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <img class="rounded initial--5" src="{{asset('storage/app/public/campaign')}}/{{$campaign->image}}" onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="Image Description">
                    </div>

                    <div class="col-md-8">
                        <h4>{{translate('messages.short')}} {{translate('messages.description')}} : </h4>
                        <p>{{$campaign->description}}</p>
                        <form action="{{route('admin.campaign.addstore',$campaign->id)}}" id="store-add-form" method="POST">
                            @csrf
                            <!-- Search -->
                            <div class="d-flex flex-wrap g-2">
                                <div class="flex-grow-1">
                                @php($allstores=App\Models\Store::Active()->where('module_id', $campaign->module_id)->get())
                                    <select name="store_id" id="store_id" class="form-control">
                                        @forelse($allstores as $store)
                                        @if(!in_array($store->id, $store_ids))
                                        <option value="{{$store->id}}" >{{$store->name}}</option>
                                        @endif
                                        @empty
                                        <option value="">{{ translate('messages.no_data_found') }}</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn--primary font-weight-regular h--45px"><i class="tio-add-circle-outlined"></i> {{translate('messages.add')}} {{translate('messages.store')}}</button>
                                </div>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                </div>
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
        <!-- Card -->
        <div class="card">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <span class="card-title"></span>
                    <form action="javascript:" id="search-form" class="search-form">
                        <!-- Search -->
                        {{-- <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control"
                                    placeholder="{{ translate('messages.Ex:') }} {{ translate('messages.store') }}" aria-label="Search" required>
                            <button type="submit" class="btn btn--secondary">
                                <i class="tio-search"></i>
                            </button>

                        </div> --}}
                        <!-- End Search -->
                    </form>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true
                        }'>
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">{{ translate('messages.SL') }}</th>
                            <th class="border-0 w--15">{{translate('messages.logo')}}</th>
                            <th class="border-0 w--2">{{translate('messages.store')}}</th>
                            <th class="border-0 w--25">{{translate('messages.owner')}}</th>
                            <th class="border-0">{{translate('messages.email')}}</th>
                            <th class="border-0">{{translate('messages.phone')}}</th>
                            <th class="border-0">{{translate('messages.status')}}</th>
                            <th class="border-0">{{translate('messages.action')}}</th>
                        </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($stores as $key=>$store)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                <img width="45" class="img--circle" onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'" src="{{asset('storage/app/public/store')}}/{{$store['logo']}}">
                            </td>
                            <td>
                                <a href="{{route('admin.store.view', $store->id)}}" class="d-block font-size-sm text-body">
                                    {{$store->name}}
                                </a>
                            </td>
                            <td>
                                <span class="d-block font-size-sm text-body">
                                    {{$store->vendor->f_name.' '.$store->vendor->l_name}}
                                </span>
                            </td>
                            <td>
                                {{$store->email}}
                            </td>
                            <td>
                                {{$store['phone']}}
                            </td>
                            @php($status = $store->pivot ? $store->pivot->campaign_status : translate('messages.not_found'))
                                <td class="text-capitalize">
                                    @if ($status == 'pending')
                                        <span class="badge badge-soft-info">
                                            {{ translate('messages.not_approved') }}
                                        </span>
                                    @elseif($status == 'confirmed')
                                        <span class="badge badge-soft-success">
                                            {{ translate('messages.confirmed') }}
                                        </span>
                                    @elseif($status == 'rejected')
                                        <span class="badge badge-soft-danger">
                                            {{ translate('messages.rejected') }}
                                        </span>
                                    @else
                                        <span class="badge badge-soft-info">
                                            {{ translate(str_replace('_', ' ', $status)) }}
                                        </span>
                                    @endif

                                </td>
                            <td>
                                @if ($store->pivot && $store->pivot->campaign_status == 'pending')
                                <div class="btn--container justify-content-center">
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                                        onclick="status_change_alert('{{ route('admin.campaign.store_confirmation', [$campaign->id, $store->id, 'confirmed']) }}', '{{ translate('messages.you_want_to_confirm_this_store') }}', event)"
                                        class="toggle-switch-input" data-toggle="tooltip" data-placement="top" title="{{translate('Approve')}}">
                                        <i class="tio-done font-weight-bold"></i>
                                    </a>
                                    <a class="btn btn-sm btn--danger btn-outline-danger action-btn" href="javascript:"
                                        onclick="status_change_alert('{{ route('admin.campaign.store_confirmation', [$campaign->id, $store->id, 'rejected']) }}', '{{ translate('messages.you_want_to_reject_this_store') }}', event)" data-toggle="tooltip" data-placement="top" title="{{translate('Deny')}}">
                                        <i class="tio-clear font-weight-bold"></i>
                                    </a>
                                    <div></div>
                                </div>
                                @elseif ($store->pivot && $store->pivot->campaign_status == 'rejected')
                
                                <div class="btn--container justify-content-center">
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                                        onclick="status_change_alert('{{ route('admin.campaign.store_confirmation', [$campaign->id, $store->id, 'confirmed']) }}', '{{ translate('messages.you_want_to_confirm_this_store') }}', event)"
                                        class="toggle-switch-input" data-toggle="tooltip" data-placement="top" title="{{translate('Approve')}}">
                                        <i class="tio-done font-weight-bold"></i>
                                    </a>
                
                                </div>
                                @else
                                <div class="btn--container justify-content-center">
                                    <a class="btn btn--danger btn-outline-danger action-btn" href="javascript:"
                                        onclick="form_alert('campaign-{{$store->id}}','{{translate('messages.want_to_remove_store')}}')" title="{{translate('messages.delete')}} {{translate('messages.campaign')}}"><i class="tio-delete-outlined"></i>
                                    </a>

                                    <form action="{{route('admin.campaign.remove-store',[$campaign->id, $store['id']])}}"
                                                    method="GET" id="campaign-{{$store->id}}">
                                        @csrf
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr>

                <div class="page-area">
                    <table>
                        <tfoot>
                        {!! $stores->links() !!}
                        </tfoot>
                    </table>
                </div>

            </div>
            <!-- End Table -->
        </div>
        <!-- End Card -->
    </div>

@endsection

@push('script_2')
    <script>
        function status_change_alert(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href=url;
                }
            })
        }
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('keyup', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script>

        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: "{{route('admin.store.search')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
