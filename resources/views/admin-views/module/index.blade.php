@extends('layouts.admin.app')

@section('title',translate('messages.business_Modules'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-flex flex-wrap align-items-center justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/module.png')}}" alt="">
                </span>
                <span>
                    {{translate('messages.business_Module_list')}}
                </span>
                <span class="badge badge-soft-dark ml-2" id="itemCount">{{$modules->total()}}</span>
            </h1>
            <div class="text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#warning-status-modal">
                <strong class="mr-2">{{translate('How it Works')}}</strong>
                <div class="blinkings">
                    <i class="tio-info-outined"></i>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <!-- Header -->
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper justify-content-end">
                    <form id="search-form" class="search-form">
                        @csrf
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" name="search" type="search" class="form-control" placeholder="{{translate('ex_:_Search_Module_by_Name')}}" aria-label="{{translate('messages.search_here')}}" value="{{request()->query('search')}}">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                            <i class="tio-download-to mr-1"></i> {{ translate('messages.export') }}
                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            {{-- <span class="dropdown-header">{{ translate('messages.options') }}</span>
                            <a id="export-copy" class="dropdown-item" href="javascript:;">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/illustrations/copy.svg"
                                    alt="Image Description">
                                {{ translate('messages.copy') }}
                            </a>
                            <a id="export-print" class="dropdown-item" href="javascript:;">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/illustrations/print.svg"
                                    alt="Image Description">
                                {{ translate('messages.print') }}
                            </a>
                            <div class="dropdown-divider"></div> --}}
                            <span class="dropdown-header">{{ translate('messages.download') }}
                                {{ translate('messages.options') }}</span>
                            <a id="export-excel" class="dropdown-item" href="{{route('admin.business-settings.module.export', ['type'=>'excel'])}}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/components/excel.svg"
                                    alt="Image Description">
                                {{ translate('messages.excel') }}
                            </a>
                            <a id="export-csv" class="dropdown-item" href="{{route('admin.business-settings.module.export', ['type'=>'csv'])}}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .{{ translate('messages.csv') }}
                            </a>
                            {{-- <a id="export-pdf" class="dropdown-item" href="javascript:;">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/components/pdf.svg"
                                    alt="Image Description">
                                {{ translate('messages.pdf') }}
                            </a> --}}
                        </div>
                    </div>
                    <a href="{{ route('admin.module.create') }}" class="btn btn--primary">+ {{translate('Add New Module')}}</a>
                    <!-- End Unfold -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-align-middle"
                        data-hs-datatables-options='{
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light border-0">
                            <tr>
                                <th class="border-0 pl-4 w--05">SL</th>
                                <th class="border-0 w--1">{{translate('messages.module_id')}}</th>
                                <th class="border-0 w--2">{{translate('messages.name')}}</th>
                                <th class="border-0 w--2">{{translate('messages.business_Module_type')}}</th>
                                <th class="border-0 w--1">{{translate('messages.status')}}</th>
                                <th class="border-0 text-center w--2">{{translate('messages.total_stores')}}</th>
                                <th class="border-0 text-center w--15">{{translate('messages.action')}}</th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                        @foreach($modules as $key=>$module)
                            <tr>
                                <td class="pl-4">{{$key+$modules->firstItem()}}</td>
                                <td>{{$module->id}}</td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{Str::limit(translate($module['module_name']), 20,'...')}}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-block font-size-sm text-body text-capitalize">
                                        {{Str::limit(translate($module['module_type']), 20,'...')}}
                                    </span>
                                </td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="status-{{$module->id}}">
                                    <input type="checkbox" class="toggle-switch-input" onclick="toogleStatusModal(event,'status-{{$module->id}}','module-on.png','module-off.png','{{translate('Want_to_activate_this')}} <strong>{{translate('Business_Module?')}}</strong>','{{translate('Want_to_deactivate_this')}} <strong>{{translate('Business_Module?')}}</strong>',`<p>{{translate('If_you_activate_this_business_module,_all_its_features_and_functionalities_will_be_available_and_accessible_to_all_users.')}}</p>`,`<p>{{translate('If_you_deactivate_this_business_module,_all_its_features_and_functionalities_will_be_disabled_and_hidden_from_users.')}}</p>`)"  
                                    {{-- onclick="location.href='{{route('admin.business-settings.module.status',[$module['id'],$module->status?0:1])}}'" --}}
                                    class="toggle-switch-input" id="status-{{$module->id}}" {{$module->status?'checked':''}}>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                    <form action="{{route('admin.business-settings.module.status',[$module['id'],$module->status?0:1])}}" method="get" id="status-{{$module->id}}_form">
                                    </form>
                                </td>
                                <td class="text-center">{{$module->stores_count}}</td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                            href="{{route('admin.business-settings.module.edit',[$module['id']])}}" title="{{translate('messages.edit')}} {{translate('messages.Business_Module')}}"><i class="tio-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer page-area pt-0 border-0">
                <!-- Pagination -->
                <div class="d-flex justify-content-center justify-content-sm-end">
                    <!-- Pagination -->
                    {!! $modules->links() !!}
                </div>
                <!-- End Pagination -->
                @if(count($modules) === 0)
                <div class="empty--data">
                    <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                    <h5>
                        {{translate('no_data_found')}}
                    </h5>
                </div>
                @endif
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="warning-modal">
        <div class="modal-dialog modal-lg warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h3 class="modal-title mb-3">{{translate('Please go to settings and select module for this zone')}}</h3>
                        <p class="txt">
                            {{translate("Otherwise this zone won't function properly & will work show anything against this zone")}}
                        </p>
                    </div>
                    <img src="{{asset('/public/assets/admin/img/zone-settings-popup-arrow.gif')}}" alt="admin/img" class="w-100">
                    {{-- <div class="mt-3 d-flex flex-wrap align-items-center justify-content-between">
                        <label class="form-check form--check m-0">
                            <input type="checkbox" class="form-check-input rounded">
                            <span class="form-check-label">{{translate("Don't show this anymore")}}</span>
                        </label>
                        <div class="btn--container justify-content-end">
                            <button id="reset_btn" type="reset" class="btn btn--reset">{{translate("I will do it later")}}</button>
                            <button type="submit" class="btn btn--primary">{{translate('Go to the Settings')}}</button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="warning-status-modal">
        <div class="modal-dialog modal-lg warning-status-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{translate('How does it works ?')}}</h2>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="how-it-works">
                        <div class="item">
                            <img src="{{asset('/public/assets/admin/img/how/how1.png')}}" alt="">
                            <h2 class="serial">{{ translate('1') }}</h2>
                            <h5>{{ translate('Create_Business_Module') }}</h5>
                            <p>
                                {{ translate('To_create_a_new_business_module,_go_to:_‘Module_Setup’_→_‘Add_Business_Module.’')}}
                            </p>
                        </div>
                        <div class="item">
                            <img src="{{asset('/public/assets/admin/img/how/how2.png')}}" alt="">
                            <h2 class="serial">{{ translate('2') }}</h2>
                            <h5>{{ translate('Add_Module_to_Zone') }}</h5>
                            <p>
                                {{ translate('Go_to_‘Zone_Setup’→_‘Business_Zone_List’→_‘Zone_Settings’→_Choose_Payment_Method→Add_Business_Module_into_Zone_with_Parameters.') }}
                            </p>
                        </div>
                        <div class="item">
                            <img src="{{asset('/public/assets/admin/img/how/how3.png')}}" alt="">
                            <h2 class="serial">{{ translate('3') }}</h2>
                            <h5>{{ translate('Create_Stores') }}</h5>
                            <p>
                                {{ translate('Select_your_Module_from_the_Module_Section,_Click_→_’Store_Management’→’Add_Store’→Add_Store_details_&_select_Zone_to_integrate_Module+Zone+Store.') }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-3 d-flex flex-wrap align-items-center justify-content-end">
                        <div class="btn--container justify-content-end">
                            <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#warning-modal" class="btn btn--primary">{{translate('next')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
{{-- <script>
    setTimeout(() => {
        $('#warning-modal').modal('show')
    }, 5000);
</script> --}}
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================

            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
        <script>
            $('#search-form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{route('admin.business-settings.module.search')}}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        $('.page-area').hide();
                        $('#table-div').html(data.view);
                        $('#itemCount').html(data.count);
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                });
            });
        </script>
@endpush
