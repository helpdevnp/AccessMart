@extends('layouts.admin.app')

@section('title',translate('FCM Settings'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/firebase.png')}}" class="w--26" alt="">
                </span>
                <span>{{translate('messages.firebase')}} {{translate('messages.push')}} {{translate('messages.notification')}} {{translate('messages.setup')}}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <?php 
        $mod_type = 'grocery';
        if(request('module_type')){
            $mod_type = request('module_type');
        }
        ?>
        <div class="card">
            <div class="card-header card-header-shadow pb-0">
                <div class="d-flex flex-wrap justify-content-between w-100 row-gap-1">
                    <ul class="nav nav-tabs nav--tabs border-0 gap-2">
                        <li class="nav-item mr-2 mr-md-4">
                            <a href="{{ route('admin.business-settings.fcm-index') }}" class="nav-link pb-2 px-0 pb-sm-3 active" data-slide="1">
                                <img src="{{asset('/public/assets/admin/img/notify.png')}}" alt="">
                                <span>{{translate('Push Notification')}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.business-settings.fcm-config') }}" class="nav-link pb-2 px-0 pb-sm-3" data-slide="2">
                                <img src="{{asset('/public/assets/admin/img/firebase2.png')}}" alt="">
                                <span>{{translate('Firebase Configuration')}}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <div class="tab--content">
                            <div class="item show text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#push-notify-modal">
                                <strong class="mr-2">{{translate('Read Documentation')}}</strong>
                                <div class="blinkings">
                                    <i class="tio-info-outined"></i>
                                </div>
                            </div>
                            <div class="item text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#firebase-modal">
                                <strong class="mr-2">{{translate('Where to get this information')}}</strong>
                                <div class="blinkings">
                                    <i class="tio-info-outined"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="push-notify">
                        @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                        @php($language = $language->value ?? null)
                        @php($default_lang = 'en')
                        <div class="row justify-content-between">
                            <div class="col-sm-auto mb-5">
                                @if($language)
                                    @php($default_lang = json_decode($language)[0])
                                    <ul class="nav nav-tabs border-0">
                                        @foreach(json_decode($language) as $lang)
                                            <li class="nav-item">
                                                <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#" id="{{$lang}}-link">{{\App\CentralLogics\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="col-sm-auto mb-5">
                                <select name="module_type" class="form-control js-select2-custom" onchange="set_filter('{{url()->full()}}',this.value,'module_type')" title="{{translate('messages.select')}} {{translate('messages.modules')}}">
                                    @foreach (config('module.module_type') as $module)
                                        <option
                                            value="{{$module}}" {{$mod_type == $module?'selected':''}}>
                                            {{ucfirst(translate($module))}}
                                        </option>
                                    @endforeach
                                </select>
                                <small>{{translate('*Select Module Here')}}</small>
                            </div>
                        </div>
                        <form action="{{route('admin.business-settings.update-fcm-messages')}}" method="post"
                                enctype="multipart/form-data">
                            @csrf

                            @if($language)
                            @php($default_lang = json_decode($language)[0])
                            @foreach(json_decode($language) as $lang_key => $lang)

                                <div class="{{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                    <div class="row">
                                        @php($opm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_pending_message')->first())
                                        @php($data=$opm?$opm:null)                         
                                        <?php
                                                if(isset($opm->translations) && count($opm->translations)){
                                                    $translate = [];
                                                    foreach($opm->translations as $t)
                                                    {   
                                                        if($t->locale == $lang && $t->key=='order_pending_message'){
                                                            $translate[$lang]['message'] = $t->value;
                                                        }
                                                    }
                                                    
                                                }
                                                ?>   
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.order')}} {{translate('messages.pending')}} {{translate('messages.message')}} ({{strtoupper($lang)}})
                                                    </span>
                                                @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center"
                                                            for="pending_status">
                                                            <input type="checkbox" onclick="toogleModal(event,'pending_status','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('pending Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('pending Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is pending')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is pending or not')}}</p>`)" name="pending_status" class="toggle-switch-input" 
                                                            @if ($lang == 'en')
                                                            onchange="add_required_attribute('pending_status', 'pending_messages')"
                                                            @endif 
                                                                value="1" id="pending_status" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                    
                                                @endif
                                                </div>
                                                <textarea name="pending_message[]"  placeholder="{{translate('Write your message')}}" class="form-control pending_messages" oninvalid="document.getElementById('en-link').click()" 
                                                @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate) && isset($translate[$lang]))?$translate[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>

                                        @php($ocm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_confirmation_msg')->first())
                                        @php($data=$ocm?$ocm:'')
                                        <?php
                                        if(isset($ocm->translations)&&count($ocm->translations)){
                                                $translate_2 = [];
                                                foreach($ocm->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='order_confirmation_msg'){
                                                        $translate_2[$lang]['message'] = $t->value;
                                                    }
                                                }
                                        
                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.order')}} {{translate('messages.confirmation')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                            for="confirm_status">
                                                            <input type="checkbox" onclick="toogleModal(event,'confirm_status','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('confirmation Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('confirmation Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is confirmed')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is confirmed or not')}}</p>`)" name="confirm_status" class="toggle-switch-input"
                                                            onchange="add_required_attribute('confirm_status', 'confirm_message')"
                                                                value="1" id="confirm_status" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        
                                                    @endif
                                                </div>
                                                <textarea name="confirm_message[]"  placeholder="{{translate('Write your message')}}" class="form-control confirm_message" oninvalid="document.getElementById('en-link').click()"
                                                @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif >{!! (isset($translate_2) && isset($translate_2[$lang]))?$translate_2[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>
                                        @if ($mod_type != 'parcel')
                                            

                                        @php($oprm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_processing_message')->first())

                                        @php($data=$oprm?$oprm:null)
                                        
                                        <?php
                                        if(isset($oprm->translations) && count($oprm->translations)){
                                                $translate_3 = [];
                                                foreach($oprm->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='order_processing_message'){
                                                        $translate_3[$lang]['message'] = $t->value;
                                                    }
                                                }
                                        
                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.order')}} {{translate('messages.processing')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0" for="processing_status">
                                                            <input type="checkbox" onclick="toogleModal(event,'processing_status','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('processing Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('processing Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is processing')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is processing or not')}}</p>`)" name="processing_status" class="toggle-switch-input"
                                                            onchange="add_required_attribute('processing_status', 'processing_message')" value="1" id="processing_status" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                            
                                                    @endif
                                                </div>
                                                <textarea name="processing_message[]"  placeholder="{{translate('Write your message')}}" class="form-control processing_message" oninvalid="document.getElementById('en-link').click()"                                         @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate_3) && isset($translate_3[$lang]))?$translate_3[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>

                                        @php($dbs=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_handover_message')->first())
                                        @php($data=$dbs?$dbs:'')
                                        <?php
                                        if(isset($dbs->translations) && count($dbs->translations)){
                                                $translate_4 = [];
                                                foreach($dbs->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='order_handover_message'){
                                                        $translate_4[$lang]['message'] = $t->value;
                                                    }
                                                }
                                        
                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.order')}} {{translate('messages.Handover')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="order_handover_message_status">
                                                            <input type="checkbox" onclick="toogleModal(event,'order_handover_message_status','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('Order Handover Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('Order Handover Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is handovered')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is handovered or not')}}</p>`)" name="order_handover_message_status"
                                                                    class="toggle-switch-input"
                                                                    onchange="add_required_attribute('order_handover_message_status', 'order_handover_message')"
                                                                    value="1"
                                                                    id="order_handover_message_status" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        
                                                    @endif
                                                </div>
                                                <textarea name="order_handover_message[]"  placeholder="{{translate('Write your message')}}" class="form-control order_handover_message" oninvalid="document.getElementById('en-link').click()"                                         @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate_4) && isset($translate_4[$lang]))?$translate_4[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>
                                        @endif


                                        @php($ofdm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','out_for_delivery_message')->first())
                                        @php($data=$ofdm?$ofdm:'')
                                        <?php
                                        if(isset($ofdm->translations) && count($ofdm->translations)){
                                                $translate_5 = [];
                                                foreach($ofdm->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='out_for_delivery_message'){
                                                        $translate_5[$lang]['message'] = $t->value;
                                                    }
                                                }
                                        
                                            }

                                        ?>
                                        
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.order')}} {{translate('messages.out_for_delivery')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="out_for_delivery">
                                                            <input type="checkbox" onclick="toogleModal(event,'out_for_delivery','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('Out For Delivery Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('Out For Delivery Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is out for delivery')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is out for delivery or not')}}</p>`)" name="out_for_delivery_status"
                                                                    class="toggle-switch-input"
                                                                    onchange="add_required_attribute('out_for_delivery', 'out_for_delivery_message')"
                                                                    value="1" id="out_for_delivery" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>
                                                    @endif
                                                </div>
                                                <textarea name="out_for_delivery_message[]"  placeholder="{{translate('Write your message')}}" class="form-control out_for_delivery_message" oninvalid="document.getElementById('en-link').click()"                                         @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate_5) && isset($translate_5[$lang]))?$translate_5[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>

                                        @php($odm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_delivered_message')->first())
                                        @php($data=$odm?$odm:'')
                                        <?php
                                        if(isset($odm->translations)&&count($odm->translations)){
                                                $translate_6 = [];
                                                foreach($odm->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='order_delivered_message'){
                                                        $translate_6[$lang]['message'] = $t->value;
                                                    }
                                                }
                                        
                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.order')}} {{translate('messages.delivered')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="delivered_status">
                                                            <input type="checkbox" onclick="toogleModal(event,'delivered_status','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('delivered Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('delivered Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is delivered')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is delivered or not')}}</p>`)" name="delivered_status"
                                                                    class="toggle-switch-input"
                                                                    onchange="add_required_attribute('delivered_status', 'delivered_message')"
                                                                    value="1" id="delivered_status" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>
                                                        
                                                    @endif
                                                </div>
                                                <textarea name="delivered_message[]"  placeholder="{{translate('Write your message')}}" class="form-control delivered_message" oninvalid="document.getElementById('en-link').click()"                                         @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate_6) && isset($translate_6[$lang]))?$translate_6[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>

                                        @php($dba=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','delivery_boy_assign_message')->first())
                                        @php($data=$dba?$dba:'')
                                        <?php
                                        if(isset($dba->translations) && count($dba->translations)){
                                                $translate_7 = [];
                                                foreach($dba->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='delivery_boy_assign_message'){
                                                        $translate_7[$lang]['message'] = $t->value;
                                                    }
                                                }
                                        
                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.deliveryman')}} {{translate('messages.assign')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                            for="delivery_boy_assign">
                                                            <input type="checkbox" onclick="toogleModal(event,'delivery_boy_assign','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('Delivery Man Assigned Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('Delivery Man Assigned Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is assigned to delivery man')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is assigned to delivery man or not')}}</p>`)" name="delivery_boy_assign_status"
                                                                class="toggle-switch-input"
                                                                onchange="add_required_attribute('delivery_boy_assign', 'delivery_boy_assign_message')"
                                                                value="1"
                                                                id="delivery_boy_assign" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        
                                                    @endif
                                                </div>
                                                <textarea name="delivery_boy_assign_message[]"  placeholder="{{translate('Write your message')}}" class="form-control delivery_boy_assign_message" oninvalid="document.getElementById('en-link').click()"                                         @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate_7) && isset($translate_7[$lang]))?$translate_7[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>

                                        @php($dbc=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','delivery_boy_delivered_message')->first())
                                        
                                        @php($data=$dbc?$dbc:'')
                                        <?php
                                        if(isset($dbc->translations) && count($dbc->translations)){
                                                $translate_8 = [];
                                                foreach($dbc->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='delivery_boy_delivered_message'){
                                                        $translate_8[$lang]['message'] = $t->value;
                                                    }
                                                }
                                        
                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.deliveryman')}} {{translate('messages.delivered')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="delivery_boy_delivered">
                                                            <input type="checkbox" onclick="toogleModal(event,'delivery_boy_delivered','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('Delivery Man Delivered Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('Delivery Man Delivered Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is delivered by delivery man')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is delivered by delivery man or not')}}</p>`)" name="delivery_boy_delivered_status"
                                                                    class="toggle-switch-input"
                                                                    onchange="add_required_attribute('delivery_boy_delivered', 'delivery_boy_delivered_message')"
                                                                    value="1"
                                                                    id="delivery_boy_delivered" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>
                                                        
                                                    @endif
                                                </div>

                                                <textarea name="delivery_boy_delivered_message[]"  placeholder="{{translate('Write your message')}}" class="form-control delivery_boy_delivered_message" oninvalid="document.getElementById('en-link').click()"                                         @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate_8) && isset($translate_8[$lang]))?$translate_8[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>

                                        @php($ocm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_cancled_message')->first())
                                        @php($data=$ocm?$ocm:'')
                                        <?php
                                        if(isset($ocm->translations) && count($ocm->translations)){

                                                $translate_9 = [];
                                                foreach($ocm->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='order_cancled_message'){
                                                        $translate_9[$lang]['message'] = $t->value;
                                                    }
                                                }
                                        
                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.order')}} {{translate('messages.canceled')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="order_cancled_message">
                                                            <input type="checkbox" onclick="toogleModal(event,'order_cancled_message','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('canceled Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('canceled Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is canceled')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is canceled or not')}}</p>`)" name="order_cancled_message_status"
                                                                    class="toggle-switch-input"
                                                                    onchange="add_required_attribute('order_cancled_message', 'order_cancled_message')"
                                                                    value="1"
                                                                    id="order_cancled_message" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>
                                                        
                                                    @endif
                                                </div>

                                                <textarea name="order_cancled_message[]"  placeholder="{{translate('Write your message')}}" class="form-control order_cancled_message" oninvalid="document.getElementById('en-link').click()"                                         @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate_9) && isset($translate_9[$lang]))?$translate_9[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>
                                        @if ($mod_type != 'parcel')
                                        @php($orm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_refunded_message')->first())
                                        @php($data=$orm?$orm:'')
                                        <?php
                                        if(isset($orm->translations)&&count($orm->translations)){
                                                $translate_10 = [];
                                                foreach($orm->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='order_refunded_message'){
                                                        $translate_10[$lang]['message'] = $t->value;
                                                    }
                                                }
                                        
                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.order')}} {{translate('messages.refunded')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                        for="order_refunded_message">
                                                            <input type="checkbox" onclick="toogleModal(event,'order_refunded_message','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('Order Refund Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('Order Refund Message')}}</strong>',`<p>{{translate('User will get a clear message to know that order is refunded')}}</p>`,`<p>{{translate('User can not get a clear message to know that order is refunded or not')}}</p>`)" name="order_refunded_message_status"
                                                                    class="toggle-switch-input"
                                                                    onchange="add_required_attribute('order_refunded_message', 'order_refunded_message')"
                                                                    value="1"
                                                                    id="order_refunded_message" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>
                                                    @endif
                                                </div>

                                                <textarea name="order_refunded_message[]"  placeholder="{{translate('Write your message')}}" class="form-control order_refunded_message" oninvalid="document.getElementById('en-link').click()"                                         @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate_10) && isset($translate_10[$lang]))?$translate_10[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>

                                        @php($rrcm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','refund_request_canceled')->first())
                                        @php($data=$rrcm?$rrcm:'')
                                        <?php
                                        if(isset($rrcm->translations) && count($rrcm->translations)){
                                                $translate_11 = [];
                                                foreach($rrcm->translations as $t)
                                                {   
                                                    if($t->locale == $lang && $t->key=='refund_request_canceled'){
                                                        $translate_11[$lang]['message'] = $t->value;
                                                    }
                                                }
                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        {{translate('messages.refund_request_canceled')}} {{translate('messages.message')}}
                                                    </span>
                                                    @if ($lang == 'en')
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                        for="refund_request_canceled">
                                                            <input type="checkbox" onclick="toogleModal(event,'refund_request_canceled','pending-order-on.png','pending-order-off.png','{{translate('By Turning ON Order ')}} <strong>{{translate('Refund Request Cancel Message')}}</strong>','{{translate('By Turning OFF Order ')}} <strong>{{translate('Refund Request Cancel Message')}}</strong>',`<p>{{translate('User will get a clear message to know that orders refund request canceled')}}</p>`,`<p>{{translate('User can not get a clear message to know that orders refund request canceled or not')}}</p>`)" name="refund_request_canceled_status"
                                                                    class="toggle-switch-input"
                                                                    onchange="add_required_attribute('refund_request_canceled', 'refund_request_canceled')"
                                                                    value="1"
                                                                    id="refund_request_canceled" {{$data?($data['status']==1?'checked':''):''}}>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>
                                                    @endif
                                                </div>
                                                <textarea name="refund_request_canceled[]"  placeholder="{{translate('Write your message')}}" class="form-control refund_request_canceled" oninvalid="document.getElementById('en-link').click()"                                         @if ($lang == 'en')
                                                {{$data?($data['status']==1?'required':''):''}}
                                                @endif 
                                                >{!! (isset($translate_11) && isset($translate_11[$lang]))?$translate_11[$lang]['message']:($data?$data['message']:'') !!}</textarea>
                                            </div>
                                        </div>
                                        @endif
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                        <input type="hidden" name="module_type" value="{{$mod_type}}">
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                                <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Firebase Modal -->
        <div class="modal fade" id="firebase-modal">
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
                                        <img src="{{asset('/public/assets/admin/img/firebase/slide-1.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('Go to Firebase Console')}}</h5>
                                    </div>
                                    <ul>
                                        <li>
                                            {{translate('Open your web browser and go to the Firebase Console')}}
                                            <a href="#" class="text--underline">
                                                {{translate('(https://console.firebase.google.com/)')}}
                                            </a>
                                        </li>
                                        <li>
                                            {{translate("Select the project for which you want to configure FCM from the Firebase Console dashboard.")}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item">
                                <div class="mb-20">
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/firebase/slide-2.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('Navigate to Project Settings')}}</h5>
                                    </div>
                                    <ul>
                                        <li>
                                            {{translate('In the left-hand menu, click on the "Settings" gear icon, and then select "Project settings" from the dropdown.')}}
                                        </li>
                                        <li>
                                            {{translate('In the Project settings page, click on the "Cloud Messaging" tab from the top menu.')}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item">
                                <div class="mb-20">
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/firebase/slide-3.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('Obtain All The Information Asked!')}}</h5>
                                    </div>
                                    <ul>
                                        <li>
                                            {{translate('In the Firebase Project settings page, click on the "General" tab from the top menu.')}}
                                        </li>
                                        <li>
                                            {{translate('Under the "Your apps" section, click on the "Web" app for which you want to configure FCM.')}}
                                        </li>
                                        <li>
                                            {{translate('Then Obtain API Key, FCM Project ID, Auth Domain, Storage Bucket, Messaging Sender ID.')}}
                                        </li>
                                    </ul>
                                    <p>
                                        {{translate('Note: Please make sure to use the obtained information securely and in accordance with Firebase and FCM documentation, terms of service, and any applicable laws and regulations.')}}
                                    </p>
                                    <div class="btn-wrap">
                                        <button type="submit" class="btn btn--primary w-100" data-dismiss="modal" data-toggle="modal" data-target="#firebase-modal-2">{{translate('Got It')}}</button>
                                    </div>
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
        <!-- Firebase Modal -->
        <div class="modal fade" id="push-notify-modal">
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
                                        <img src="{{asset('/public/assets/admin/img/email-templates/3.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('Write_a_message_in_the_Notification_Body')}}</h5>
                                    </div>
                                    <p>
                                        {{ translate('you_can_add_your_message_using_placeholders_to_include_dynamic_content._Here_are_some_examples_of_placeholders_you_can_use:') }}
                                    </p>
                                    <ul>
                                        <li>
                                            {userName}: {{ translate('the_name_of_the_user.') }}
                                        </li>
                                        <li>
                                            {storeName}: {{ translate('the_name_of_the_store.') }}
                                        </li>
                                        <li>
                                            {orderId}: {{ translate('the_order_id.') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item">
                                <div class="mb-20">
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/firebase/slide-4.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('Please Visit the Docs to Set FCM on Mobile Apps')}}</h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('Please check the documentation below for detailed instructions on setting up your mobile app to receive Firebase Cloud Messaging (FCM) notifications.')}}
                                        </p>
                                        <a href="https://docs.6amtech.com/docs-six-am-mart/mobile-apps/mandatory-setup" target="_blank">{{translate('Click Here')}}</a>
                                    </div>
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

        <!-- Change Order Status Modal -->
        <div class="modal fade" id="order-status-modal">
            <div class="modal-dialog status-warning-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true" class="tio-clear"></span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="text-center mb-20">
                            <!-- Warning Content -->
                            <!-- <img src="{{asset('/public/assets/admin/img/modal/pending-order-off.png')}}" alt="" class="mb-20">
                            <h5 class="modal-title">{{translate('By Turning OFF Order ')}}<strong class="font-bold">{{translate('Pending Message')}}</strong></h5>
                            <p class="txt">
                                {{translate("User can't get a clear message to know that order is pending or not")}}
                            </p> -->
                            <!-- Success Content -->
                            <img src="{{asset('/public/assets/admin/img/modal/pending-order-on.png')}}" alt="" class="mb-20">
                            <h5 class="modal-title">{{translate('By Turning ON Order ')}} <strong class="font-bold">{{translate('Pending Message')}}</strong></h5>
                            <p class="txt">
                                {{translate("User will get a clear message to know that order is pending")}}
                            </p>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button type="submit" class="btn btn--primary min-w-120" data-dismiss="modal">{{translate('Ok')}}</button>
                            <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">{{translate("Cancel")}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')

<script>
    $('[data-slide]').on('click', function(){
        let serial = $(this).data('slide')
        $(`.tab--content .item`).removeClass('show')
        $(`.tab--content .item:nth-child(${serial})`).addClass('show')
    })
</script>


<script>

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
<script>
    $(".lang_link").click(function(e){
        e.preventDefault();
        $(".lang_link").removeClass('active');
        $(".lang_form").addClass('d-none');
        $(this).addClass('active');

        let form_id = this.id;
        let lang = form_id.substring(0, form_id.length - 5);
        console.log(lang);
        $("#"+lang+"-form").removeClass('d-none');
        if(lang == '{{$default_lang}}')
        {
            $("#from_part_2").removeClass('d-none');
        }
        else
        {
            $("#from_part_2").addClass('d-none');
        }
    })
</script>

<script>
    function add_required_attribute(status, name, lang_en){
        if($('#'+status).is(':checked')){
            $('#en-form .'+name).attr('required', true);
        } else {
            $('#en-form .'+name).removeAttr('required');
        }
    }
</script>

@endpush
