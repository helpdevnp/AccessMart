@extends('layouts.admin.app')

@section('title',translate('messages.react_landing_page'))

@section('content')
<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/landing.png')}}" class="w--20" alt="">
                </span>
                <span>
                    {{ translate('messages.react_landing_page') }}
                </span>
            </h1>
            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#how-it-works">
                <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                <div>
                    <i class="tio-info-outined"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            @include('admin-views.business-settings.landing-page-settings.top-menu-links.react-landing-page-links')
        </div>
    </div>
    
    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
    @php($language = $language->value ?? null)
    @php($default_lang = str_replace('_', '-', app()->getLocale()))
    @if($language)
        <ul class="nav nav-tabs mb-4 border-0">
            <li class="nav-item">
                <a class="nav-link lang_link active"
                href="#"
                id="default-link">{{translate('messages.default')}}</a>
            </li>
            @foreach (json_decode($language) as $lang)
                <li class="nav-item">
                    <a class="nav-link lang_link"
                        href="#"
                        id="{{ $lang }}-link">{{ \App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}</a>
                </li>
            @endforeach
        </ul>
    @endif
    @php($business_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','business_title')->first())
    @php($business_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','business_sub_title')->first())
    @php($download_app_links = \App\Models\DataSetting::where(['key'=>'download_business_app_links','type'=>'react_landing_page'])->first())
    @php($download_app_links = isset($download_app_links->value)?json_decode($download_app_links->value, true):null)

    @php($business_image=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','business_image')->first())
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <form action="{{ route('admin.business-settings.react-landing-page-settings', 'business-section') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end">
                            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#business_section">
                                <strong class="mr-2">{{translate('See_the_changes_here.')}}</strong>
                                <div>
                                    <i class="tio-intersect"></i>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row g-4">
                            <div class="col-md-6">
                                @if ($language)
                                <div class="col-md-12 lang_form default-form">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Title')}} ({{ translate('messages.default') }})
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_30_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="30" name="business_title[]" value="{{ $business_title?->getRawOriginal('value')??'' }}" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Sub Title')}} ({{ translate('messages.default') }})
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_35_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="35" name="business_sub_title[]" value="{{ $business_sub_title?->getRawOriginal('value')??'' }}" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                    @foreach(json_decode($language) as $lang)
                                    <?php
                                    if(isset($business_title->translations)&&count($business_title->translations)){
                                            $business_title_translate = [];
                                            foreach($business_title->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='business_title'){
                                                    $business_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                    
                                        }
                                    if(isset($business_sub_title->translations)&&count($business_sub_title->translations)){
                                            $business_sub_title_translate = [];
                                            foreach($business_sub_title->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='business_sub_title'){
                                                    $business_sub_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                    
                                        }
                                        ?>
                                    <div class="col-md-12 d-none lang_form" id="{{$lang}}-form1">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">{{translate('Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_30_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="30" name="business_title[]" value="{{ $business_title_translate[$lang]['value']??'' }}" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">{{translate('Sub Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_35_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="35" name="business_sub_title[]" value="{{ $business_sub_title_translate[$lang]['value']??'' }}" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                            </div>
                                        </div>
                                    </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                    @endforeach
                                @else
                                <div class="col-md-12">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Title')}}</label>
                                            <input type="text" name="business_title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Sub Title')}}</label>
                                            <input type="text" name="business_sub_title[]" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                        </div>
                                    </div>
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block mb-2">
                                    {{ translate('messages.Banner') }}  <span class="text--primary">(size: 1:1)</span>
                                </label>
                                <label class="upload-img-3 m-0">
                                    <div class="position-relative">
                                    <div class="img">
                                        <img src="{{asset('storage/app/public/business_image')}}/{{ $business_image['value']??'' }}" onerror='this.src="{{asset('/public/assets/admin/img/aspect-1.png')}}"' alt="" class="img__aspect-1 min-w-187px max-w-187px">
                                    </div>
                                      <input type="file"  name="image" hidden>
                                         @if (isset($business_image['value']))
                                            <span id="business_image" class="remove_image_button"
                                                onclick="toogleStatusModal(event,'business_image','mail-success','mail-warning','{{translate('Important!')}}','{{translate('Warning!')}}',`<p>{{translate('Are_you_sure_you_want_to_remove_this_image')}}</p>`,`<p>{{translate('Are_you_sure_you_want_to_remove_this_image.')}}</p>`)"
                                                > <i class="tio-clear"></i></span>
                                            @endif
                                        </div>
                                </label>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-12">
                                <h5 class="card-title mb-5">
                                    <img src="{{asset('public/assets/admin/img/seller.png')}}" class="mr-2" alt="">
                                    {{translate('Download the Seller App')}}
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title mb-2">
                                            <img src="{{asset('public/assets/admin/img/playstore.png')}}" class="mr-2" alt="">
                                            {{translate('Playstore Button')}}
                                        </h5>
                                        <div class="__bg-F8F9FC-card">
                                            <div class="form-group mb-md-0">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="form-label text-capitalize m-0">
                                                        {{translate('Download Link')}}
                                                               {{-- <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum">
                                                            <i class="tio-info-outined"></i>
                                                        </span> --}}
                                                    </label>
                                                    <label class="toggle-switch toggle-switch-sm m-0">
                                                        <input type="checkbox" name="seller_playstore_url_status" onclick="toogleModal(event,'play-store-seller-status','play-store-on.png','play-store-off.png','{{translate('Playstore Button Enabled for Seller')}}','{{translate('Playstore Button Disabled for Seller')}}',`<p>{{translate('Playstore button is enabled now everyone can use or see the button')}}</p>`,`<p>{{translate('Playstore button is disabled now no one can use or see the button')}}</p>`)" id="play-store-seller-status" class="status toggle-switch-input" value="1" {{(isset($download_app_links) && $download_app_links['seller_playstore_url_status'])?'checked':''}}>
                                                        <span class="toggle-switch-label text mb-0">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <input type="text" placeholder="{{translate('Ex: https://play.google.com/store/apps')}}" class="form-control h--45px" name="seller_playstore_url" value="{{isset($download_app_links['seller_playstore_url']) ? $download_app_links['seller_playstore_url']:''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title mb-2">
                                            <img src="{{asset('public/assets/admin/img/ios.png')}}" class="mr-2" alt="">
                                            {{translate('App Store Button')}}
                                        </h5>
                                        <div class="__bg-F8F9FC-card">
                                            <div class="form-group mb-md-0">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="form-label text-capitalize m-0">
                                                        {{translate('Download Link')}}
                                                               {{-- <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum">
                                                            <i class="tio-info-outined"></i>
                                                        </span> --}}
                                                    </label>
                                                    <label class="toggle-switch toggle-switch-sm m-0">
                                                        <input type="checkbox" name="seller_appstore_url_status" onclick="toogleModal(event,'apple-seller-status','apple-on.png','apple-off.png','{{translate('App Store Button Enabled for Seller')}}','{{translate('App Store Button Disabled for Seller')}}',`<p>{{translate('App Store button is enabled now everyone can use or see the button')}}</p>`,`<p>{{translate('App Store button is disabled now no one can use or see the button')}}</p>`)" id="apple-seller-status" class="status toggle-switch-input" value="1" {{(isset($download_app_links) && $download_app_links['seller_appstore_url_status'])?'checked':''}}>
                                                        <span class="toggle-switch-label text mb-0">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <input type="text" placeholder="{{translate('Ex: https://www.apple.com/app-store/')}}" class="form-control h--45px" name="seller_appstore_url" value="{{isset($download_app_links['seller_appstore_url']) ? $download_app_links['seller_appstore_url']:''}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-12">
                                <h5 class="card-title mb-5">
                                    <img src="{{asset('public/assets/admin/img/dm.png')}}" class="mr-2" alt="">
                                    {{translate('Download the Deliveryman App')}}
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title mb-2">
                                            <img src="{{asset('public/assets/admin/img/playstore.png')}}" class="mr-2" alt="">
                                            {{translate('Playstore Button')}}
                                        </h5>
                                        <div class="__bg-F8F9FC-card">
                                            <div class="form-group mb-md-0">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="form-label text-capitalize m-0">
                                                        {{translate('Download Link')}}
                                                               {{-- <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum">
                                                            <i class="tio-info-outined"></i>
                                                        </span> --}}
                                                    </label>
                                                    <label class="toggle-switch toggle-switch-sm m-0">
                                                        <input type="checkbox" name="dm_playstore_url_status" onclick="toogleModal(event,'play-store-dm-status','play-store-on.png','play-store-off.png','{{translate('Playstore Button Enabled for Delivery Man')}}','{{translate('Playstore Button Disabled for Delivery Man')}}',`<p>{{translate('Playstore button is enabled now everyone can use or see the button')}}</p>`,`<p>{{translate('Playstore button is disabled now no one can use or see the button')}}</p>`)" id="play-store-dm-status" class="status toggle-switch-input" value="1" {{(isset($download_app_links) && $download_app_links['dm_playstore_url_status'])?'checked':''}}>
                                                        <span class="toggle-switch-label text mb-0">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <input type="text" placeholder="{{translate('Ex: https://play.google.com/store/apps')}}" class="form-control h--45px" name="dm_playstore_url" value="{{isset($download_app_links['dm_playstore_url']) ? $download_app_links['dm_playstore_url']:''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title mb-2">
                                            <img src="{{asset('public/assets/admin/img/ios.png')}}" class="mr-2" alt="">
                                            {{translate('App Store Button')}}
                                        </h5>
                                        <div class="__bg-F8F9FC-card">
                                            <div class="form-group mb-md-0">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="form-label text-capitalize m-0">
                                                        {{translate('Download Link')}}
                                                               {{-- <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum">
                                                            <i class="tio-info-outined"></i>
                                                        </span> --}}
                                                    </label>
                                                    <label class="toggle-switch toggle-switch-sm m-0">
                                                        <input type="checkbox" name="dm_appstore_url_status" onclick="toogleModal(event,'apple-dm-status','apple-on.png','apple-off.png','{{translate('App Store Button Enabled for Delivery Man')}}','{{translate('App Store Button Disabled for Delivery Man')}}',`<p>{{translate('App Store button is enabled now everyone can use or see the button')}}</p>`,`<p>{{translate('App Store button is disabled now no one can use or see the button')}}</p>`)" id="apple-dm-status" class="status toggle-switch-input" value="1" {{(isset($download_app_links) && $download_app_links['dm_appstore_url_status'])?'checked':''}}>
                                                        <span class="toggle-switch-label text mb-0">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <input type="text" placeholder="{{translate('Ex: https://www.apple.com/app-store/')}}" class="form-control h--45px" name="dm_appstore_url" value="{{isset($download_app_links['dm_appstore_url']) ? $download_app_links['dm_appstore_url']:''}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-3">
                            <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                            <button type="submit" onclick="" class="btn btn--primary mb-2">{{translate('Save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
                        <form  id="business_image_form" action="{{ route('admin.remove_image') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{  $business_image?->id}}" >
                {{-- <input type="hidden" name="json" value="1" > --}}
                <input type="hidden" name="model_name" value="DataSetting" >
                <input type="hidden" name="image_path" value="business_image" >
                <input type="hidden" name="field_name" value="value" >
            </form> 
            <!-- Module Setup Section View -->
            <div class="modal fade" id="business_section">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3">{{translate('Download Apps Section')}}</h3>
                            </div>
                            <img src="{{asset('/public/assets/admin/img/zone-instruction.png')}}" alt="admin/img" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- App Store Modal -->
            <div class="modal fade" id="user-app">
                <div class="modal-dialog status-warning-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true" class="tio-clear"></span>
                            </button>
                        </div>
                        <div class="modal-body pb-5 pt-0">
                            <div class="max-349 mx-auto mb-20">
                                <div>
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/user-app-off.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning OFF User App Button')}}</h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('User app button will be disabled. Nobody can use or see the button')}}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div>
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/user-app-on.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning ON User App Button')}}</h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('User app button will be enabled. everyone can use or see the button')}}
                                        </p>
                                    </div>
                                </div> -->
                                <div class="btn--container justify-content-center">
                                    <button type="submit" class="btn btn--primary min-w-120" data-dismiss="modal">{{translate('Ok')}}</button>
                                    <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">                
                                        {{translate("Cancel")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- App Store Modal -->
            <div class="modal fade" id="deliveryman-app">
                <div class="modal-dialog status-warning-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true" class="tio-clear"></span>
                            </button>
                        </div>
                        <div class="modal-body pb-5 pt-0">
                            <div class="max-349 mx-auto mb-20">
                                <div>
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/dm-app-off.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning OFF Delivery Man App Button')}}</h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('Seller app button will be disabled. Nobody can use or see the button')}}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div>
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/dm-app-on.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning ON Delivery Man App Button')}}</h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('Playstore button will be enabled. everyone can use or see the button')}}
                                        </p>
                                    </div>
                                </div> -->
                                <div class="btn--container justify-content-center">
                                    <button type="submit" class="btn btn--primary min-w-120" data-dismiss="modal">{{translate('Ok')}}</button>
                                    <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">                
                                        {{translate("Cancel")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Play Store Modal -->
            <div class="modal fade" id="seller-app">
                <div class="modal-dialog status-warning-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true" class="tio-clear"></span>
                            </button>
                        </div>
                        <div class="modal-body pb-5 pt-0">
                            <div class="max-349 mx-auto mb-20">
                                <div>
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/seller-app-off.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning OFF Seller App Button')}}</h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('Seller app button will be disabled. Nobody can use or see the button')}}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div>
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/seller-app-on.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning ON Seller App Button')}}</h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('Playstore button will be enabled. everyone can use or see the button')}}
                                        </p>
                                    </div>
                                </div> -->
                                <div class="btn--container justify-content-center">
                                    <button type="submit" class="btn btn--primary min-w-120" data-dismiss="modal">{{translate('Ok')}}</button>
                                    <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">                
                                        {{translate("Cancel")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- How it Works -->
@include('admin-views.business-settings.landing-page-settings.partial.how-it-work-react')
@endsection
@push('script_2')
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
        $("#"+lang+"-form1").removeClass('d-none');
        if(lang == '{{$default_lang}}')
        {
            $(".from_part_2").removeClass('d-none');
        }
        if(lang == 'default')
        {
            $(".default-form").removeClass('d-none');
        }
        else
        {
            $(".from_part_2").addClass('d-none');
        }
    });
</script>
@endpush