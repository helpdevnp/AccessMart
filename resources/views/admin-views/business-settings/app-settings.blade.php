@extends('layouts.admin.app')

@section('title',translate('messages.app_settings'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-flex flex-wrap align-items-center justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/setting.png')}}" class="w--26" alt="">
                </span>
                <span>
                    {{translate('messages.app_settings')}}
                </span>
            </h1>
            <div class="text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#how-it-works">
                <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                <div class="blinkings">
                    <i class="tio-info-outined"></i>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        @php($app_minimum_version_android=\App\Models\BusinessSetting::where(['key'=>'app_minimum_version_android'])->first())
        @php($app_minimum_version_android=$app_minimum_version_android?$app_minimum_version_android->value:null)

        @php($app_url_android=\App\Models\BusinessSetting::where(['key'=>'app_url_android'])->first())
        @php($app_url_android=$app_url_android?$app_url_android->value:null)

        @php($app_minimum_version_ios=\App\Models\BusinessSetting::where(['key'=>'app_minimum_version_ios'])->first())
        @php($app_minimum_version_ios=$app_minimum_version_ios?$app_minimum_version_ios->value:null)

        @php($app_url_ios=\App\Models\BusinessSetting::where(['key'=>'app_url_ios'])->first())
        @php($app_url_ios=$app_url_ios?$app_url_ios->value:null)

        @php($app_minimum_version_android_store=\App\Models\BusinessSetting::where(['key'=>'app_minimum_version_android_store'])->first())
        @php($app_minimum_version_android_store=$app_minimum_version_android_store?$app_minimum_version_android_store->value:null)
        @php($app_url_android_store=\App\Models\BusinessSetting::where(['key'=>'app_url_android_store'])->first())
        @php($app_url_android_store=$app_url_android_store?$app_url_android_store->value:null)

        @php($app_minimum_version_ios_store=\App\Models\BusinessSetting::where(['key'=>'app_minimum_version_ios_store'])->first())
        @php($app_minimum_version_ios_store=$app_minimum_version_ios_store?$app_minimum_version_ios_store->value:null)
        @php($app_url_ios_store=\App\Models\BusinessSetting::where(['key'=>'app_url_ios_store'])->first())
        @php($app_url_ios_store=$app_url_ios_store?$app_url_ios_store->value:null)

        @php($app_minimum_version_android_deliveryman=\App\Models\BusinessSetting::where(['key'=>'app_minimum_version_android_deliveryman'])->first())
        @php($app_minimum_version_android_deliveryman=$app_minimum_version_android_deliveryman?$app_minimum_version_android_deliveryman->value:null)
        @php($app_url_android_deliveryman=\App\Models\BusinessSetting::where(['key'=>'app_url_android_deliveryman'])->first())
        @php($app_url_android_deliveryman=$app_url_android_deliveryman?$app_url_android_deliveryman->value:null)
        
        @php($app_minimum_version_ios_deliveryman=\App\Models\BusinessSetting::where(['key'=>'app_minimum_version_ios_deliveryman'])->first())
        @php($app_minimum_version_ios_deliveryman=$app_minimum_version_ios_deliveryman?$app_minimum_version_ios_deliveryman->value:null)
        @php($app_url_ios_deliveryman=\App\Models\BusinessSetting::where(['key'=>'app_url_ios_deliveryman'])->first())
        @php($app_url_ios_deliveryman=$app_url_ios_deliveryman?$app_url_ios_deliveryman->value:null)

        <form action="{{route('admin.business-settings.app-settings')}}" method="post"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="user_app" >
            <h5 class="card-title mb-3 pt-3">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{ translate('User App Version Control') }}</span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h5 class="card-title mb-3">
                                <img src="{{asset('/public/assets/admin/img/andriod.png')}}" class="mr-2" alt="">
                                {{ translate('For android') }}
                            </h5>
                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">
                                        {{translate('Minimum_User_App_Version')}} ({{translate('messages.android')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('The_minimum_user_app_version_required_for_the_app_functionality.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input type="number" placeholder="{{translate('messages.app_minimum_version')}}" class="form-control" step="0.001" name="app_minimum_version_android"
                                        value="{{env('APP_MODE')!='demo'?$app_minimum_version_android??'':''}}">
                                </div>
                                <div class="form-group mb-md-0">
                                    <label class="form-label">
                                        {{translate('Download_URL_for_User_App')}} ({{translate('messages.android')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Users_will_download_the_latest_user_app_version_using_this_URL.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input type="text" placeholder="{{translate('messages.app_url')}}" class="form-control" name="app_url_android"
                                        value="{{env('APP_MODE')!='demo'?$app_url_android??'':''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title mb-3">
                                <img src="{{asset('/public/assets/admin/img/ios.png')}}" class="mr-2" alt="">
                                {{ translate('For iOS') }}
                            </h5>
                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">{{translate('Minimum_User_App_Version')}} ({{translate('messages.ios')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('The_minimum_user_app_version_required_for_the_app_functionality.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input type="number" placeholder="{{translate('messages.app_minimum_version')}}" class="form-control" step="0.001" name="app_minimum_version_ios"
                                        value="{{env('APP_MODE')!='demo'?$app_minimum_version_ios??'':''}}">
                                </div>
                                <div class="form-group mb-md-0">
                                    <label class="form-label">
                                        {{translate('Download_URL_for_User_App')}} ({{translate('messages.ios')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Users_will_download_the_latest_user_app_version_using_this_URL.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input type="text" placeholder="{{translate('messages.app_url')}}" class="form-control" name="app_url_ios"
                                        value="{{env('APP_MODE')!='demo'?$app_url_ios??'':''}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn--primary mb-2">{{translate('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>


        <form action="{{route('admin.business-settings.app-settings')}}" method="post"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="store_app" >
            <h5 class="card-title mb-3 pt-4">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{ translate('Store_App_Version_Control') }}</span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h5 class="card-title mb-3">
                                <img src="{{asset('/public/assets/admin/img/andriod.png')}}" class="mr-2" alt="">
                                {{ translate('For android') }}
                            </h5>
                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label text-capitalize">{{translate('Minimum_Store_App_Version')}} {{translate('messages.for_store')}} ({{translate('messages.android')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('The_minimum_store_app_version_required_for_the_app_functionality.') }}">
                                        <i class="tio-info-outined"></i>
                                    </span>
                                    </label>
                                    <input type="number" placeholder="{{translate('messages.app_minimum_version')}}" class="form-control h--45px" name="app_minimum_version_android_store"
                                        step="0.001"   min="0" value="{{env('APP_MODE')!='demo'?$app_minimum_version_android_store??'':''}}">
                                </div>
                                <div class="form-group mb-md-0">
                                    <label class="form-label text-capitalize">
                                        {{translate('Download_URL_for_Store_App')}} {{translate('messages.for_store')}} ({{translate('messages.android')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Users_will_download_the_latest_store_app_using_this_URL.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input type="text" placeholder="{{translate('messages.Download_Url')}}" class="form-control h--45px" name="app_url_android_store"
                                        value="{{env('APP_MODE')!='demo'?$app_url_android_store??'':''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title mb-3">
                                <img src="{{asset('/public/assets/admin/img/ios.png')}}" class="mr-2" alt="">
                                {{ translate('For iOS') }}
                            </h5>
                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label text-capitalize">{{translate('Minimum_Store_App_Version')}} ({{translate('messages.ios')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('The_minimum_store_app_version_required_for_the_app_functionality.') }}">
                                        <i class="tio-info-outined"></i>
                                    </span>
                                    </label>
                                    <input type="number" placeholder="{{translate('messages.app_minimum_version')}}" class="form-control h--45px" name="app_minimum_version_ios_store"
                                    step="0.001"  min="0" value="{{env('APP_MODE')!='demo'?$app_minimum_version_ios_store??'':''}}">
                                </div>
                                <div class="form-group mb-md-0">
                                    <label class="form-label text-capitalize">
                                        {{translate('Download_URL_for_Store_App')}} ({{translate('messages.ios')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Users_will_download_the_latest_store_app_version_using_this_URL.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input type="text" placeholder="{{translate('messages.Download_Url')}}" class="form-control h--45px" name="app_url_ios_store"
                                    value="{{env('APP_MODE')!='demo'?$app_url_ios_store??'':''}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn--primary mb-2">{{translate('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>


        <form action="{{route('admin.business-settings.app-settings')}}" method="post"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="deliveryman_app" >
            <h5 class="card-title mb-3 pt-4">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{ translate('Deliveryman_App_Version_Control') }}</span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h5 class="card-title mb-3">
                                <img src="{{asset('/public/assets/admin/img/andriod.png')}}" class="mr-2" alt="">
                                {{ translate('For android') }}
                            </h5>
                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label text-capitalize">{{translate('Minimum_Deliveryman_App_Version')}} ({{translate('messages.android')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('The_minimum_deliveryman_app_version_required_for_the_app_functionality.') }}">
                                        <i class="tio-info-outined"></i>
                                    </span>
                                    </label>
                                    <input type="number" placeholder="{{translate('messages.app_minimum_version')}}" class="form-control h--45px" name="app_minimum_version_android_deliveryman"
                                        step="0.001"   min="0" value="{{env('APP_MODE')!='demo'?$app_minimum_version_android_deliveryman??'':''}}">
                                </div>
                                <div class="form-group mb-md-0">
                                    <label class="form-label text-capitalize">
                                        {{translate('Download_URL_for_Deliveryman_App')}} ({{translate('messages.android')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Users_will_download_the_latest_deliveryman_app_version_using_this_URL.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input type="text" placeholder="{{translate('messages.Download_Url')}}" class="form-control h--45px" name="app_url_android_deliveryman"
                                    value="{{env('APP_MODE')!='demo'?$app_url_android_deliveryman??'':''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title mb-3">
                                <img src="{{asset('/public/assets/admin/img/ios.png')}}" class="mr-2" alt="">
                                {{ translate('For iOS') }}
                            </h5>
                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label text-capitalize">{{translate('Minimum_Deliveryman_App_Version')}} ({{translate('messages.ios')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('The_minimum_deliveryman_app_version_required_for_the_app_functionality.') }}">
                                        <i class="tio-info-outined"></i>
                                    </span>
                                    </label>
                                    <input type="number" placeholder="{{translate('messages.app_minimum_version')}}" class="form-control h--45px" name="app_minimum_version_ios_deliveryman"
                                    step="0.001"  min="0" value="{{env('APP_MODE')!='demo'?$app_minimum_version_ios_deliveryman??'':''}}">
                                </div>
                                <div class="form-group mb-md-0">
                                    <label class="form-label text-capitalize">
                                        {{translate('Download_URL_for_Deliveryman_App')}} ({{translate('messages.ios')}})
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Users_will_download_the_latest_deliveryman_app_version_using_this_URL.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input type="text" placeholder="{{translate('messages.Download_Url')}}" class="form-control h--45px" name="app_url_ios_deliveryman"
                                    value="{{env('APP_MODE')!='demo'?$app_url_ios_deliveryman??'':''}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn--primary mb-2">{{translate('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <div class="modal fade" id="how-it-works">
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
                                    <h5 class="modal-title">{{translate('What_is_App_Version?')}}</h5>
                                </div>
                                <ul>
                                    <li>
                                        {{ translate('This_app_version_defines_the_Store,_Deliveryman,_and_User_app_version_of_6amMart.') }}
                                    </li>
                                    <li>
                                        {{ translate('It_doesn’t_represent_the_Play_Store_or_App_Store_version.') }}
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
                                       {{ translate('The_app_download_link_is_the_URL_from_which_users_can_update_the_app_by_clicking_the_`Update_App`_button_from_their_app.') }}
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
    </div>
@endsection

@push('script_2')

@endpush
