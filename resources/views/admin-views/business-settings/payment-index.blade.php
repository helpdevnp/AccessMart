@extends('layouts.admin.app')

@section('title',translate('messages.Payment Method'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->

        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('/public/assets/admin/img/payment.png')}}" class="w--22" alt="">
                </span>
                <span>
                    {{translate('messages.payment')}} {{translate('messages.gateway')}} {{translate('messages.setup')}}
                </span>
            </h1>
            @include('admin-views.business-settings.partials.third-party-links')
            <div class="d-flex flex-wrap justify-content-end align-items-center flex-grow-1">
                <div class="blinkings trx_top active">
                    <i class="tio-info-outined"></i>
                    <div class="business-notes">
                        <h6><img src="{{asset('/public/assets/admin/img/notes.png')}}" alt=""> {{translate('Note')}}</h6>
                        <div>
                            {{translate('Without configuring this section functionality will not work properly. Thus the whole system will not work as it planned')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card border-0">
            <div class="card-header card-header-shadow">
                <h5 class="card-title align-items-center">
                    <img src="{{asset('/public/assets/admin/img/payment-method.png')}}" class="mr-1" alt="">
                    {{translate('Payment Method')}}
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('cash_on_delivery'))
                        <form action="{{route('admin.business-settings.third-party.payment-method-update',['cash_on_delivery'])}}"
                            method="post" id="cash_on_delivery_status_form">
                            @csrf
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        {{translate('Cash On Delivery')}}
                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum dolor set amet"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input class="toggle-switch-input" type="checkbox" id="cash_on_delivery_status" onclick="toogleStatusModal(event,'cash_on_delivery_status','digital-payment-on.png','digital-payment-off.png','{{translate('By Turning ON Cash On Delivery Option')}}','{{translate('By Turning OFF Cash On Delivery Option')}}',`<p>{{translate('Customers will not be able to select COD as a payment method during checkout. Please review your settings and enable COD if you wish to offer this payment option to customers.')}}</p>`,`<p>{{translate('Customers will be able to select COD as a payment method during checkout.')}}</p>`)" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>
                    <div class="col-md-6">
                        @php($digital_payment=\App\CentralLogics\Helpers::get_business_settings('digital_payment'))
                        <form action="{{route('admin.business-settings.third-party.payment-method-update',['digital_payment'])}}"
                            method="post" id="digital_payment_status_form">
                            @csrf
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        {{translate('digital payment')}}
                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum dolor set amet"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input class="toggle-switch-input" type="checkbox" id="digital_payment_status" onclick="toogleStatusModal(event,'digital_payment_status','digital-payment-on.png','digital-payment-off.png','{{translate('By Turning ON Digital Payment Option')}}','{{translate('By Turning OFF Digital Payment Option')}}',`<p>{{translate('Customers will not be able to select digital payment as a payment method during checkout. Please review your settings and enable digital payment if you wish to offer this payment option to customers.')}}</p>`,`<p>{{translate('Customers will be able to select digital payment as a payment method during checkout.')}}</p>`)" name="status" value="1" {{$digital_payment?($digital_payment['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row digital_payment_methods mt-3 g-3">
            <!-- This Design Will Implement On All Digital Payment Method Its an Static Design Card Start -->
            @php($config=\App\CentralLogics\Helpers::get_business_settings('ssl_commerz_payment'))
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        <form
                        action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['ssl_commerz_payment']):'javascript:'}}"
                        method="post">
                        @csrf
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.sslcommerz')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" name="status" value="1" class="toggle-switch-input" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/sslcommerz.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" name="store_id" placeholder="Store ID" value="{{env('APP_MODE')!='demo'?($config?$config['store_id']:''):''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" name="store_password" placeholder="Store Password" value="{{env('APP_MODE')!='demo'?($config?$config['store_password']:''):''}}">
                            </div>
                            <div class="text-right">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paypal'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['paypal']):'javascript:'}}"
                            method="post">
                            @csrf
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.paypal')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/paypal.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <label for="mode">{{ translate('messages.select_payment_mode') }}</label>
                                <select name="mode" class="form-control" id="sel1">
                                    <option value="test" {{isset($config['mode'])?($config['mode'] == 'test'?'selected':''):''}}>Test</option>
                                    <option value="live" {{isset($config['mode'])?($config['mode'] == 'live'?'selected':''):''}}>Live</option>
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Paypal Client Id" name="paypal_client_id"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['paypal_client_id']:''):''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Paypal Secret" name="paypal_secret"
                                           value="{{env('APP_MODE')!='demo'?$config['paypal_secret']??'':''}}">
                            </div>
                            <div class="text-right">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('razor_pay'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['razor_pay']):'javascript:'}}"
                            method="post">
                            @csrf
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.razorpay')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/razorpay.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Razor Key" name="razor_key"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['razor_key']:''):''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Razor Secret" name="razor_secret"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['razor_secret']:''):''}}">
                            </div>
                            <div class="text-right">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('stripe'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['stripe']):'javascript:'}}"
                              method="post">
                            @csrf
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.stripe')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/stripe.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Publish Key" name="published_key"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['published_key']:''):''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Api Key" name="api_key"
                                           value="{{env('APP_MODE')!='demo'?($config?$config['api_key']:''):''}}">
                            </div>
                            <div class="text-right">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paystack'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['paystack']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.paystack')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <span class="badge badge-soft-danger">{{translate('messages.paystack_callback_warning')}}</span>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/paystack.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Public Key" name="publicKey"
                                           value="{{env('APP_MODE')!='demo'?$config['publicKey']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Secret Key" name="secretKey"
                                           value="{{env('APP_MODE')!='demo'?$config['secretKey']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Payment Url" name="paymentUrl"
                                           value="{{env('APP_MODE')!='demo'?$config['paymentUrl']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Merchant Email" name="merchantEmail"
                                           value="{{env('APP_MODE')!='demo'?$config['merchantEmail']:''}}">
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="button" class="btn h--37px btn-success"onclick="copy_text('{{url('/')}}/paystack-callback')">{{translate('messages.copy_callback')}}</button>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                            @else
                            <button type="submit"
                                    class="btn btn--primary mb-2">{{translate('messages.configure')}}</button>



                        @endif

                    </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('senang_pay'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['senang_pay']):'javascript:'}}"
                              method="post">
                            @csrf
                            @if(isset($config))
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.senang')}} {{translate('messages.pay')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/senang-pay.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Secret Key" name="secret_key"
                                           value="{{env('APP_MODE')!='demo'?$config['secret_key']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Merchant Key" name="merchant_id"
                                           value="{{env('APP_MODE')!='demo'?$config['merchant_id']:''}}">
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                            @else
                            <button type="submit"
                                    class="btn btn--primary mb-2">{{translate('messages.configure')}}</button>



                        @endif

                    </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('flutterwave'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['flutterwave']):'javascript:'}}"
                              method="post">
                            @csrf
                            @if(isset($config))
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.flutterwave')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/flutterwave.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Public Key" name="public_key"
                                           value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Secret Key" name="secret_key"
                                           value="{{env('APP_MODE')!='demo'?$config['secret_key']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Hash" name="hash"
                                           value="{{env('APP_MODE')!='demo'?$config['hash']:''}}">
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                            @else
                            <button type="submit"
                                    class="btn btn--primary mb-2">{{translate('messages.configure')}}</button>



                        @endif

                    </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('mercadopago'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['mercadopago']):'javascript:'}}"
                              method="post">
                              @csrf
                            @if(isset($config))
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.mercadopago')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/mercador-pago.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Public Key" name="public_key"
                                           value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Access Token" name="access_token"
                                           value="{{env('APP_MODE')!='demo'?$config['access_token']:''}}">
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                            @else
                            <button type="submit"
                                    class="btn btn--primary mb-2">{{translate('messages.configure')}}</button>



                        @endif

                    </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paymob_accept'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['paymob_accept']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.paymob_accept')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/paymob.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <label class="{{Session::get('direction') === 'rtl' ? 'pr-3' : 'pl-3'}}">{{translate('messages.callback')}}</label>
                                <span class="btn btn-secondary btn-sm m-2"
                                    onclick="copyToClipboard('#id_paymob_accept')"><i class="tio-copy"></i> {{translate('messages.copy_callback')}}</span>

                                <p class="form-control" id="id_paymob_accept">{{ url('/') }}/paymob-callback</p>
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Api Key" name="api_key"
                                           value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Iframe Id" name="iframe_id"
                                           value="{{env('APP_MODE')!='demo'?$config['iframe_id']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Integration Id" name="integration_id"
                                           value="{{env('APP_MODE')!='demo'?$config['integration_id']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="HMAC" name="hmac"
                                           value="{{env('APP_MODE')!='demo'?$config['hmac']:''}}">
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                            @else
                            <button type="submit"
                                    class="btn btn--primary mb-2">{{translate('messages.configure')}}</button>



                        @endif

                    </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('bkash'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['bkash']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.bkash')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/bkash.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Api Key" name="api_key"
                                           value="{{env('APP_MODE')!='demo'?$config['api_key']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Api Secret" name="api_secret"
                                           value="{{env('APP_MODE')!='demo'?$config['api_secret']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Username" name="username"
                                           value="{{env('APP_MODE')!='demo'?$config['username']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Password" name="password"
                                           value="{{env('APP_MODE')!='demo'?$config['password']:''}}">
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                            @else
                            <button type="submit"
                                    class="btn btn--primary mb-2">{{translate('messages.configure')}}</button>



                        @endif

                    </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paytabs'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['paytabs']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.paytabs')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/paytabs.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Profile Id" name="profile_id"
                                           value="{{env('APP_MODE')!='demo'?$config['profile_id']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Server Key" name="server_key"
                                           value="{{env('APP_MODE')!='demo'?$config['server_key']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Base Url by Region" name="base_url"
                                           value="{{env('APP_MODE')!='demo'?$config['base_url']:''}}">
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                            @else
                            <button type="submit"
                                    class="btn btn--primary mb-2">{{translate('messages.configure')}}</button>



                        @endif

                    </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('paytm'))
                        <form
                            action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['paytm']):'javascript:'}}"
                            method="post">
                            @csrf
                            @if(isset($config))
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.paytm')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/paytm.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Paytm Merchant Key" name="paytm_merchant_key"
                                           value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_key']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Paytm Merchant Mid" name="paytm_merchant_mid"
                                           value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_mid']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Merchant Website" name="paytm_merchant_website"
                                           value="{{env('APP_MODE')!='demo'?$config['paytm_merchant_website']:''}}">
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                            @else
                            <button type="submit"
                                    class="btn btn--primary mb-2">{{translate('messages.configure')}}</button>



                        @endif

                    </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-30px">
                        @php($config=\App\CentralLogics\Helpers::get_business_settings('liqpay'))
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update',['liqpay']):'javascript:'}}"
                              method="post">
                            @csrf
                            @if(isset($config))
                        <h5 class="d-flex flex-wrap justify-content-between">
                            <strong>{{translate('messages.liqpay')}}</strong>
                            <label class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                <span class="mr-2 switch--custom-label-text text-primary on text-uppercase">{{ translate('messages.on') }}</span>
                                <span class="mr-2 switch--custom-label-text off text-uppercase">{{ translate('messages.off') }}</span>
                                <input type="checkbox" class="toggle-switch-input" name="status" value="1" {{$config?($config['status']==1?'checked':''):''}}>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </h5>
                        <div class="payment--gateway-img">
                            <img src="{{asset('/public/assets/admin/img/payment/liqpay.png')}}" alt="public">
                        </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Public Key" name="public_key"
                                           value="{{env('APP_MODE')!='demo'?$config['public_key']:''}}">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="text" placeholder="Private Key" name="private_key"
                                           value="{{env('APP_MODE')!='demo'?$config['private_key']:''}}">
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn h--37px btn--primary">{{translate('messages.save')}}</button>
                            </div>
                            @else
                            <button type="submit"
                                    class="btn btn--primary mb-2">{{translate('messages.configure')}}</button>



                        @endif

                    </form>
                    </div>
                </div>
            </div>
            
        </div>

    </div>

    
    <div class="modal fade" id="status-warning-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center mb-20">
                        <img src="{{asset('/public/assets/admin/img/cod.png')}}" alt="" class="mb-20">
                        <h5 class="modal-title">{{translate('By Turning OFF Cash On Delivery Option')}}</h5>
                        <p>{{translate("Customers will not be able to select COD as a payment method during checkout. Please review your settings and enable COD if you wish to offer this payment option to customers.")}}</p>
                    </div>
                    <div class="btn--container justify-content-center">
                        <button type="submit" class="btn btn--primary min-w-120" data-dismiss="modal">{{translate('Ok')}}</button>
                        <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">{{translate("Cancel")}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script_2')
<script>
    @if(!isset($digital_payment) || $digital_payment['status']==0)
        $('.digital_payment_methods').hide();
    @endif
    $(document).ready(function () {
        $('.digital_payment').on('click', function(){
            if($(this).val()=='0')
            {
                $('.digital_payment_methods').addClass('blurry');
            }
            else
            {
                $('.digital_payment_methods').removeClass('blurry');
            }
        })
    });
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();

        toastr.success("{{translate('messages.text_copied')}}");
    }


    function checkedFunc() {
        $('.switch--custom-label .toggle-switch-input').each( function() {
            if(this.checked) {
                $(this).closest('.switch--custom-label').addClass('checked')
            }else {
                $(this).closest('.switch--custom-label').removeClass('checked')
            }
        })
    }
    checkedFunc()
    $('.switch--custom-label .toggle-switch-input').on('change', checkedFunc)


</script>
@endpush
