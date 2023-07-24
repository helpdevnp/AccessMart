@extends('layouts.admin.app')

@section('title', translate('messages.customer_settings'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="{{ asset('public/assets/admin/img/business.png') }}" class="w--26" alt="">
                </span>
                <span>
                    {{translate('business_setup')}}
                </span>
            </h1>
            
            @include('admin-views.business-settings.partials.nav-menu')
            
        </div>
        <!-- Page Header -->

        <!-- End Page Header -->
        <form action="{{ route('admin.customer.update-settings') }}" method="post" enctype="multipart/form-data"
            id="update-settings">
            @csrf
            <div class="row gx-2">
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header card-header-shadow">
                            <h5 class="card-title d-flex align-items-center">
                                <img src="{{asset('/public/assets/admin/img/wallet-icon.png')}}" alt="" class="card-header-icon align-self-center mr-1">
                                <span>
                                    {{translate('Wallet')}}
                                </span>
                                <span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.Here,_customers_can_store_their_refunded_order_amount,_referral_earnings,_and_loyalty_points.') }}"><img src="{{ asset('/public/assets/admin/img/info-circle.svg') }}" alt="{{ translate('messages.show_hide_food_menu') }}"></span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control">
                                            <span class="pr-2">{{ translate('Customer Can Earn & Buy From Wallet') }}
                                                <span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.With_this_feature,_customers_can_have_virtual_wallets_in_their_account_via_Customer_App_&_Website._They_can_also_earn_(via_referral,_refund,_or_loyalty_points)_and_buy_with_the_wallet’s_amount.')}}">
                                              <img src="{{ asset('/public/assets/admin/img/info-circle.svg') }}" alt="{{ translate('messages.show_hide_food_menu') }}">
                                                </span>
                                            </span>
                                            <input type="checkbox" onclick="toogleModal(event,'wallet_status','wallet-on.png','wallet-off.png','{{translate('messages.Want_to_enable')}} <strong>{{translate('the_Wallet_feature?')}}</strong>','{{translate('messages.Want_to_disable')}} <strong>{{translate('the_Wallet_feature?')}}</strong>',`<p>{{translate('messages.If_you_enable_this,_Customers_can_see_&_use_the_Wallet_option_from_their_profile_in_the_Customer_App_&_Website.')}}</p>`,`<p>{{translate('messages.If_you_disable_this,_the_Wallet_feature_will_be_hidden_from_the_Customer_App_&_Website.')}}</p>`)" name="customer_wallet"
                                            id="wallet_status" value="1" class="toggle-switch-input" {{ isset($data['wallet_status']) && $data['wallet_status'] == 1 ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control">
                                            <span class="pr-2">{{ translate('messages.refund_to_wallet') }}<span
                                                    class="input-label-secondary"
                                                    data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.If_it’s_enabled,_Customers_will_automatically_receive_the_refunded_amount_in_their_wallets._But_if_it’s_disabled,_the_Admin_will_handle_the_Refund_Request_in_his_convenient_transaction_channel.') }}"><img
                                                        src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                        alt="{{ translate('messages.show_hide_food_menu') }}"></span></span>
                                            <input type="checkbox" onclick="toogleModal(event,'refund_to_wallet','refund-on.png','refund-off.png','{{translate('messages.Want_to_enable')}} <strong>{{translate('messages.Refund_to_Wallet_feature?')}}</strong>','{{translate('messages.Want_to_disable')}} <strong>{{translate('messages.Refund_to_Wallet_feature?')}}</strong>',`<p>{{translate('messages.If_you_enable_this,_Customers_will_automatically_receive_the_refunded_amount_in_their_wallets.')}}</p>`,`<p>{{translate('messages.If_you_disable_this,_the_Admin_will_handle_the_Refund_Request_in_his_convenient_transaction_channel.')}}</p>`)" class="toggle-switch-input" name="refund_to_wallet"
                                                id="refund_to_wallet" value="1"
                                                {{ isset($data['wallet_add_refund']) && $data['wallet_add_refund'] == 1 ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header card-header-shadow">
                            <h5 class="card-title d-flex align-items-center">
                                <img src="{{asset('/public/assets/admin/img/referral.png')}}" alt="" class="card-header-icon align-self-center mr-1">
                                <span class="pr-2">
                                    {{ translate('Referral Earning') }}
                                </span>
                                <span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.Existing_Customers_can_share_a_referral_code_with_others_to_earn_a_referral_bonus._For_this,_the_new_user_MUST_sign_up_using_the_referral_code_and_make_their_first_purchase.') }}">
                                    <img src="{{ asset('/public/assets/admin/img/info-circle.svg') }}" alt="{{ translate('messages.show_hide_food_menu') }}">
                                </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-group mb-0">
                                        <label
                                            class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control">
                                            <span
                                                class="pr-2">{{ translate('Customer Can Earn & Buy From Referral') }}</span>
                                            <input type="checkbox" class="toggle-switch-input"
                                            onclick="toogleModal(event,'ref_earning_status','referral-on.png','referral-off.png','{{translate('messages.Want_to_enable')}} <strong>{{translate('messages.Referral_Earning?')}}</strong>','{{translate('messages.Want_to_disable')}} <strong>{{translate('messages.Referral_Earning?')}}</strong>',`<p>{{translate('messages.If_you_enable_this,_Customers_can_earn_points_by_referring_others_to_sign_up_&_purchase_from_your_business.')}}</p>`,`<p>{{translate('messages.If_you_disable_this,_the_referral-earning_feature_will_be_hidden_from_the_Customer_App_&_Website.')}}</p>`)"
                                                {{-- onclick="section_visibility('ref_earning_status')" --}}
                                                name="ref_earning_status" id="ref_earning_status"
                                                data-section="referrer-earning" value="1"
                                                {{ isset($data['ref_earning_status']) && $data['ref_earning_status'] == 1 ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="referrer_earning_exchange_rate">
                                            {{ translate('Earning Per Referral ($)', ['currency' => \App\CentralLogics\Helpers::currency_code()]) }}
                                        </label>
                                            <input type="number" class="form-control" name="ref_earning_exchange_rate"
                                            value="{{ $data['ref_earning_exchange_rate'] ?? '0' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-body py-4">
                            <div class="row g-3 mt-0">
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control">
                                            <span class="pr-2">{{ translate('Customer Verification') }}
                                                <span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.If_you_activate_this_feature,_customers_need_to_verify_their_account_information_via_OTP_during_the_signup_process.') }}">
                                                    <img src="{{ asset('/public/assets/admin/img/info-circle.svg') }}" alt="{{ translate('messages.show_hide_food_menu') }}">
                                                </span>
                                            </span>
                                            <input type="checkbox" onclick="toogleModal(event,'customer_verification_status','customer-verification-on.png','customer-verification-off.png','{{translate('messages.Want_to_enable')}} <strong>{{translate('messages.Customer_Verification?')}}</strong>','{{translate('messages.Want_to_disable')}} <strong>{{translate('messages.Customer_Verification?')}}</strong>',`<p>{{translate('messages.If_you_enable_this,_Customers_have_to_verify_their_account_via_OTP.')}}</p>`,`<p>{{translate('messages.If_you_disable_this,_Customers_don’t_need_to_verify_their_account_via_OTP.')}}</p>`)" name="customer_verification_status"
                                            id="customer_verification_status" value="1"  class="toggle-switch-input" {{ isset($data['customer_verification']) && $data['customer_verification'] == 1 ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header card-header-shadow">
                            <h5 class="card-title">
                                <img src="{{asset('/public/assets/admin/img/loyalty.png')}}" alt="" class="card-header-icon align-self-center mr-1">
                                <span>
                                    {{ translate('Loyalty Point') }}
                                </span>
                            </h5>
                        </div>
                        <div class="card-body py-4">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-group mb-0">
                                        <label
                                            class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control"
                                            for="customer_loyalty_point">
                                            <span class="pr-2">{{ translate('Customer Can Earn Loyalty Point') }}</span>
                                            <input type="checkbox" class="toggle-switch-input"
                                            onclick="toogleModal(event,'customer_loyalty_point','loyalty-on.png','loyalty-off.png','{{translate('messages.Want_to_enable')}} <strong>{{translate('Loyalty Point')}}</strong>','{{translate('messages.Want_to_disable')}} <strong>{{translate('Loyalty Point')}}</strong>',`<p>{{translate('Customer will see loyalty point option in his profile settings & can earn & convert this point to wallet money')}}</p>`,`<p>{{translate('Customer will no see loyalty point option from his profile settings')}}</p>`)"
                                                onchange="section_visibility('customer_loyalty_point')" 
                                                name="customer_loyalty_point"
                                                id="customer_loyalty_point" data-section="loyalty-point-section" value="1"
                                                {{ isset($data['loyalty_point_status']) && $data['loyalty_point_status'] == 1 ? 'checked' : '' }}>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="intem_purchase_point">
                                            {{ translate('Loyalty Point Earn Per Order (%)') }}
                                            <small class="text-danger"><span class="input-label-secondary"
                                                    data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.item_purchase_point_hint') }}"><img
                                                        src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                        alt="{{ translate('messages.item_purchase_point_hint') }}"></span> *</small>
                                        </label>
                                        <input type="number" class="form-control" name="item_purchase_point" step=".01"
                                            value="{{ $data['loyalty_point_item_purchase_point'] ?? '0' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="intem_purchase_point">
                                            {{ translate('Minimum Loyalty Point Required to Transfer', ['currency' => \App\CentralLogics\Helpers::currency_code()]) }}
                                        </label>
                                        <input type="number" class="form-control" name="minimun_transfer_point" min="0"
                                            value="{{ $data['loyalty_point_minimum_point'] ?? '0' }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="loyalty_point_exchange_rate">{{ translate('messages.point_to_currency_exchange_rate', ['currency' => \App\CentralLogics\Helpers::currency_code()]) }}</label>
                                        <input type="number" class="form-control" name="loyalty_point_exchange_rate"
                                            value="{{ $data['loyalty_point_exchange_rate'] ?? '0' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="btn--container justify-content-end">
                        <button type="reset" id="reset_btn" class="btn btn--reset">{{ translate('reset') }}</button>
                        <button type="submit" id="submit" class="btn btn--primary">{{ translate('Save Information') }}</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- End Table -->
    </div>
@endsection
@push('script_2')
    <script>
        $(document).on('ready', function() {
            // @if (isset($data['wallet_status']) && $data['wallet_status'] != 1)
            //     $('.wallet-section').hide();
            // @endif
            // @if (isset($data['loyalty_point_status']) && $data['loyalty_point_status'] != 1)
            //     $('.loyalty-point-section').hide();
            // @endif
            // @if (isset($data['ref_earning_status']) && $data['ref_earning_status'] != 1)
            //     $('.referrer-earning').hide();
            // @endif

            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));
            $('#column1_search').on('keyup', function() {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });


            $('#column3_search').on('change', function() {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });
        });
    </script>

    <script>
        function section_visibility(id) {
            console.log($('#' + id).data('section'));
            if ($('#' + id).is(':checked')) {
                console.log('checked');
                $('.' + $('#' + id).data('section')).show();
            } else {
                console.log('unchecked');
                $('.' + $('#' + id).data('section')).hide();
            }
        }
        $('#add_fund').on('submit', function(e) {

            e.preventDefault();
            var formData = new FormData(this);

            Swal.fire({
                title: '{{ translate('messages.are_you_sure') }}',
                text: '{{ translate('messages.you_want_to_add_fund') }}' + $('#amount').val() +
                    ' {{ \App\CentralLogics\Helpers::currency_code() . ' ' . translate('messages.to') }} ' + $(
                        '#customer option:selected').text() + '{{ translate('messages.to_wallet') }}',
                type: 'info',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: 'primary',
                cancelButtonText: '{{ translate('messages.no') }}',
                confirmButtonText: '{{ translate('messages.send') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post({
                        url: '{{ route('admin.customer.wallet.add-fund') }}',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            if (data.errors) {
                                for (var i = 0; i < data.errors.length; i++) {
                                    toastr.error(data.errors[i].message, {
                                        CloseButton: true,
                                        ProgressBar: true
                                    });
                                }
                            } else {
                                toastr.success(
                                    '{{ translate('messages.fund_added_successfully') }}', {
                                        CloseButton: true,
                                        ProgressBar: true
                                    });
                            }
                        }
                    });
                }
            })
        })
    </script>
        <script>
            $('#reset_btn').click(function(){
                location.reload(true);
            })
        </script>
@endpush
