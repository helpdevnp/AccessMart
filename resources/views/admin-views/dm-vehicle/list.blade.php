@extends('layouts.admin.app')

@section('title',translate('messages.Vehicle_List'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-car"></i> {{translate('messages.vehicles_category_list')}} <span class="badge badge-soft-dark ml-2" id="itemCount">{{$vehicles->total()}}</span></h1>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn--primary" href="{{route('admin.users.delivery-man.vehicle.create')}}">
                        <i class="tio-add"></i> {{translate('messages.add_vehicle_category')}}
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title"></h5>
                            <form id="search-form">
                                <!-- Search -->
                                <div class="input--group input-group input-group-merge input-group-flush">
                                    <input id="datatableSearch" type="search" name="search" class="form-control" placeholder="{{ translate('Ex_:_Search_by_type...') }}" aria-label="Search here">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="font-size-sm table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th>{{ translate('messages.sl') }}</th>
                                <th >{{translate('messages.Type')}}</th>
                                <th >{{translate('messages.minimum_coverage_area')}} ({{ translate('messages.km') }}) </th>
                                <th >{{translate('messages.Maximum_coverage_area')}} ({{ translate('messages.km') }})</th>
                                <th >{{translate('messages.Extra_charges')}}  ({{ \App\CentralLogics\Helpers::currency_symbol() }})</th>
                                <th>{{translate('messages.status')}}</th>
                                <th class="text-center">{{translate('messages.action')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($vehicles as $key=>$vehicle)
                                <tr>
                                    <td>{{$key+$vehicles->firstItem()}}</td>
                                    <td>
                                        <span class="d-block text-body"><a href="{{route('admin.users.delivery-man.vehicle.view',[$vehicle->id])}}">{{Str::limit($vehicle['type'],25, '...')}}</a>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark">
                                            {{ $vehicle->starting_coverage_area }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark">
                                            {{ $vehicle->maximum_coverage_area }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark">
                                         {{ \App\CentralLogics\Helpers::format_currency($vehicle->extra_charges) }}
                                        </span>
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$vehicle->id}}">
                                            <input type="checkbox" onclick="location.href='{{route('admin.users.delivery-man.vehicle.status',[$vehicle['id'],$vehicle->status?0:1])}}'"class="toggle-switch-input" id="stocksCheckbox{{$vehicle->id}}" {{$vehicle->status?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                                                href="{{route('admin.users.delivery-man.vehicle.edit',[$vehicle['id']])}}" title="{{translate('messages.edit_vehicle')}}"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn--danger btn-outline-danger action-btn" href="javascript:"
                                                onclick="form_alert('vehicle-{{$vehicle['id']}}','{{translate('messages.Want_to_delete_this_item')}}')" title="{{translate('messages.delete_vehicle')}}"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="{{route('admin.users.delivery-man.vehicle.delete',['vehicle' =>$vehicle['id']])}}"
                                                        method="post" id="vehicle-{{$vehicle['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(count($vehicles) === 0)
                        <div class="empty--data">
                            <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                            <h5>
                                {{translate('no_data_found')}}
                            </h5>
                        </div>
                        @endif
                        <div class="page-area px-4 pb-3">
                            <div class="d-flex align-items-center justify-content-end">
                                <div>
                                    {!! $vehicles->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
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



        });
    </script>
@endpush
