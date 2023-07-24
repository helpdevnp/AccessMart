@extends('layouts.admin.app')

@section('title', translate('store_setup'))


@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="{{ asset('public/assets/admin/img/business.png') }}" class="w--26" alt="">
                </span>
                <span>
                    {{ translate('messages.business') }} {{ translate('messages.setup') }}
                </span>
            </h1>
            @include('admin-views.business-settings.partials.nav-menu')
        </div>
        <form action="{{ route('admin.business-settings.update-store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @php($name = \App\Models\BusinessSetting::where('key', 'business_name')->first())

            <div class="row g-3">
                @php($default_location = \App\Models\BusinessSetting::where('key', 'default_location')->first())
                @php($default_location = $default_location->value ? json_decode($default_location->value, true) : 0)
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-4 col-sm-6">
                                    @php($canceled_by_store = \App\Models\BusinessSetting::where('key', 'canceled_by_store')->first())
                                    @php($canceled_by_store = $canceled_by_store ? $canceled_by_store->value : 0)
                                    <div class="form-group mb-0">
                                        <label class="input-label text-capitalize d-flex alig-items-center"><span
                                                class="line--limit-1">{{ translate('messages.Can_a_Store_Cancel_Order?') }}
                                            </span><span class="input-label-secondary text--title" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="{{ translate('messages.Admin_can_enable/disable_Store’s_order_cancellation_option.') }}">
                                                <i class="tio-info-outined"></i>
                                            </span></label>
                                        <div class="resturant-type-group border">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="1"
                                                    name="canceled_by_store" id="canceled_by_restaurant"
                                                    {{ $canceled_by_store == 1 ? 'checked' : '' }}>
                                                <span class="form-check-label">
                                                    {{ translate('yes') }}
                                                </span>
                                            </label>
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="0"
                                                    name="canceled_by_store" id="canceled_by_restaurant2"
                                                    {{ $canceled_by_store == 0 ? 'checked' : '' }}>
                                                <span class="form-check-label">
                                                    {{ translate('no') }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    @php($store_self_registration = \App\Models\BusinessSetting::where('key', 'toggle_store_registration')->first())
                                    @php($store_self_registration = $store_self_registration ? $store_self_registration->value : 0)
                                    <div class="form-group mb-0">

                                        <label
                                            class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                            <span class="pr-1 d-flex align-items-center switch--label">
                                                <span class="line--limit-1">
                                                    {{ translate('messages.store_self_registration') }}
                                                </span>
                                                <span class="form-label-secondary text-danger d-flex"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="{{ translate('messages.A_store_can_send_a_registration_request_through_their_store_or_customer.') }}"><img
                                                        src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                        alt="{{ translate('messages.store_self_registration') }}"> *
                                                </span>
                                            </span>
                                            <input type="checkbox" onclick="toogleModal(event,'store_self_registration1','store-self-reg-on.png','store-self-reg-off.png','{{translate('messages.Want_to_enable')}} <strong>{{translate('messages.Store_Self_Registration?')}}</strong>','{{translate('messages.Want_to_disable')}} <strong>{{translate('messages.Store_Self_Registration?')}}</strong>',`<p>{{translate('messages.If_you_enable_this,_Stores_can_do_self-registration_from_the_store_or_customer_app_or_website.')}}</p>`,`<p>{{translate('messages.If_you_disable_this,_the_Store_Self-Registration_feature_will_be_hidden_from_the_store_or_customer_app,_website,_or_admin_landing_page.')}}</p>`)" class="toggle-switch-input" value="1"
                                                name="store_self_registration" id="store_self_registration1"
                                                {{ $store_self_registration == 1 ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-3">
                                <button type="reset" class="btn btn--reset">{{ translate('messages.reset') }}</button>
                                <button type="{{ env('APP_MODE') != 'demo' ? 'submit' : 'button' }}"
                                    onclick="{{ env('APP_MODE') != 'demo' ? '' : 'call_demo()' }}"
                                    class="btn btn--primary">{{ translate('save_information') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                
            <!-- Store Self Reg Modal -->
            {{-- <div class="modal fade" id="store-self-reg-modal">
                <div class="modal-dialog status-warning-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true" class="tio-clear"></span>
                            </button>
                        </div>
                        <div class="modal-body pb-5 pt-0">
                            <div class="max-349 mx-auto mb-20">
                                <div class="confirm-toogle d-none">
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/store-self-reg-off.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning OFF ')}} <strong>{{translate('Store Self Registration')}}</strong></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('User can’t register to open a store all by him self from user website or Store App . He has to contact admin & request to open a store')}}
                                        </p>
                                    </div>
                                </div>
                                <div class="cancel-toogle d-none">
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/store-self-reg-on.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning ON ')}} <strong>{{translate('Store Self Registration')}}</strong></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('User can register to open a store all by him self from user website or Store App ')}}
                                        </p>
                                    </div>
                                </div>
                                <div class="btn--container justify-content-center">
                                    <button type="button" class="btn btn--primary min-w-120" data-dismiss="modal" onclick="confirmToggle('store_self_registration1','store-self-reg-modal')">{{translate('Ok')}}</button>
                                    <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">                
                                        {{translate("Cancel")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </form>
    </div>

@endsection

@push('script_2')

@endpush
