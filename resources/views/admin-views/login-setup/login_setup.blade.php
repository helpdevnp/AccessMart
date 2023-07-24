@extends('layouts.admin.app')

@section('title',translate('messages.login_page_setup'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-flex flex-wrap align-items-center justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/app.png')}}" class="w--26" alt="">
                </span>
                <span>
                    {{translate('messages.login_page_setup')}}
                </span>
            </h1>
            {{-- <div class="text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#how-it-works">
                <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                <div class="blinkings">
                    <i class="tio-info-outined"></i>
                </div>
            </div> --}}
        </div>
        <!-- End Page Header -->


        <form action="{{route('admin.business-settings.login_url_update')}}" method="post">
        @csrf
            <h5 class="card-title mb-3 pt-3">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{ translate('Admin_login_page') }}</span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h5 class="card-title mb-3">
                                {{-- <img src="{{asset('/public/assets/admin/img/andriod.png')}}" class="mr-2" alt=""> --}}
                                {{-- {{ translate('For_admin') }} --}}
                            </h5>
                            <input type="text" hidden  name="type" value="admin">
                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">
                                        {{translate('messages.Admin_login_url')}}
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Add_dynamic_url_to_secure_admin_login_access.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ url('/') }}/login/</div>
                                        <input type="text" placeholder="{{translate('messages.admin_login_url')}}" class="form-control h--45px" name="admin_login_url"
                                                required value="{{ $data['admin_login_url'] ?? null  }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn--primary mb-2">{{translate('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{route('admin.business-settings.login_url_update')}}" method="post">
            @csrf
            <h5 class="card-title mb-3 pt-3">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{ translate('admin_employee_login_page') }}</span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h5 class="card-title mb-3">
                                {{-- <img src="{{asset('/public/assets/admin/img/andriod.png')}}" class="mr-2" alt=""> --}}
                                {{-- {{ translate('For_admin_employee') }} --}}
                            </h5>
                            <input type="text" hidden  name="type" value="admin_employee">

                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">
                                        {{translate('messages.admin_employee_login_url')}}
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Add_dynamic_url_to_secure_admin_employee_login_access.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ url('/') }}/login/</div>
                                        <input type="text" placeholder="{{translate('messages.admin_employee_login_url')}}" class="form-control h--45px" name="admin_employee_login_url"
                                                required value="{{ $data['admin_employee_login_url'] ?? null  }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn--primary mb-2">{{translate('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{route('admin.business-settings.login_url_update')}}" method="post">
            @csrf
            <h5 class="card-title mb-3 pt-3">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{ translate('store_login_page') }}</span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h5 class="card-title mb-3">
                                {{-- <img src="{{asset('/public/assets/admin/img/andriod.png')}}" class="mr-2" alt=""> --}}
                                {{-- {{ translate('For_stores') }} --}}
                            </h5>
                            <input type="text" hidden  name="type" value="store">

                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">
                                        {{translate('messages.store_login_url')}}
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Add_dynamic_url_to_secure_store_login_access.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ url('/') }}/login/</div>
                                        <input type="text" placeholder="{{translate('messages.store_login_url')}}" class="form-control h--45px" name="store_login_url"
                                        required value="{{ $data['store_login_url'] ?? null  }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn--primary mb-2">{{translate('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{route('admin.business-settings.login_url_update')}}" method="post">
            @csrf
            <h5 class="card-title mb-3 pt-3">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{ translate('store_employee_login_page') }}</span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h5 class="card-title mb-3">
                                {{-- <img src="{{asset('/public/assets/admin/img/andriod.png')}}" class="mr-2" alt=""> --}}
                                {{-- {{ translate('For_store_employee') }} --}}
                            </h5>
                            <input type="text" hidden  name="type" value="store_employee">

                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">
                                        {{translate('messages.store_employee_login_url')}}
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Add_dynamic_url_to_secure_store_employee_login_access.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ url('/') }}/login/</div>
                                        <input type="text" placeholder="{{translate('messages.store_employee_login_url')}}" class="form-control h--45px" name="store_employee_login_url"
                                                required value="{{ $data['store_employee_login_url'] ?? null  }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn--primary mb-2">{{translate('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>



    </div>

    {{-- <div class="modal fade" id="how-it-works">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="single-item-slider owl-carousel">
                        <div class="item">
                            <div class="mb-20">
                                <div class="text-center">
                                    <img src="{{asset('/public/assets/admin/img/app.png')}}" alt="" class="mb-20">
                                    <h5 class="modal-title">{{translate('What is App Version ?')}}</h5>
                                </div>
                                <ul>
                                    <li>
                                        {{ translate('This_version_is_not_the_version_of_your_play_store_or_app_store_version.') }}
                                    </li>
                                    <li>
                                        {{ translate('App_version_means_the_APP_VERSION_variable_value_exist_in_the_app_constant.dirt_file') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mb-20">
                                <div class="text-center">
                                    <img src="{{asset('/public/assets/admin/img/app.png')}}" alt="" class="mb-20">
                                    <h5 class="modal-title">{{translate('App Download Link')}}</h5>
                                </div>
                                <ul>
                                    <li>
                                        {{ translate('App_download_link_represents_the_link_from_where_the_user_will_update_the_app_after_clicking_update_app_button_from_their_app') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="slide-counter"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

@push('script_2')

@endpush
