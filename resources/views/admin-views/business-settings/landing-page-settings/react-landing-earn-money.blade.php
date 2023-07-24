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
    @php($earning_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_title')->first())
    @php($earning_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_sub_title')->first())
    @php($earning_seller_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_seller_title')->first())
    @php($earning_seller_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_seller_sub_title')->first())
    @php($earning_seller_button_name=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_seller_button_name')->first())
    @php($earning_seller_button_url=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_seller_button_url')->first())
    @php($earning_dm_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_dm_title')->first())
    @php($earning_dm_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_dm_sub_title')->first())
    @php($earning_dm_button_name=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_dm_button_name')->first())
    @php($earning_dm_button_url=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','earning_dm_button_url')->first())
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
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <form action="{{ route('admin.business-settings.react-landing-page-settings', 'earning-title') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h5 class="card-title mb-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{translate('Download User App Section Content ')}}</span>
                </h5>
                <div class="card mb-3">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end mb-2">
                            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#admin-earn-money">
                                <strong class="mr-2">{{translate('See_the_changes_here.')}}</strong>
                                <div>
                                    <i class="tio-intersect"></i>
                                </div>
                            </div>
                        </div> --}}
                        @if ($language)
                            <div class="row g-3 lang_form default-form">
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Title')}} ({{ translate('messages.default') }})
                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_40_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="40" name="earning_title[]" class="form-control" value="{{$earning_title?->getRawOriginal('value')??''}}" placeholder="{{translate('messages.title_here...')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Sub Title')}} ({{ translate('messages.default') }})
                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="80" name="earning_sub_title[]" class="form-control" value="{{$earning_sub_title?->getRawOriginal('value')??''}}" placeholder="{{translate('messages.sub_title_here...')}}">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                @foreach(json_decode($language) as $lang)
                                <?php
                                if(isset($earning_title->translations)&&count($earning_title->translations)){
                                        $earning_title_translate = [];
                                        foreach($earning_title->translations as $t)
                                        {   
                                            if($t->locale == $lang && $t->key=='earning_title'){
                                                $earning_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                
                                    }
                                if(isset($earning_sub_title->translations)&&count($earning_sub_title->translations)){
                                        $earning_sub_title_translate = [];
                                        foreach($earning_sub_title->translations as $t)
                                        {   
                                            if($t->locale == $lang && $t->key=='earning_sub_title'){
                                                $earning_sub_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                
                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="{{$lang}}-form">
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_40_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="40" name="earning_title[]" class="form-control" value="{{ $earning_title_translate[$lang]['value']?? '' }}" placeholder="{{translate('messages.title_here...')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Sub Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="80" name="earning_sub_title[]" class="form-control" value="{{ $earning_sub_title_translate[$lang]['value']?? '' }}" placeholder="{{translate('messages.sub_title_here...')}}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach
                            @else
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Title')}}</label>
                                        <input type="text" name="earning_title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Sub Title')}}</label>
                                        <input type="text" name="earning_sub_title[]" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            @endif
                        <div class="btn--container justify-content-end mt-3">
                            <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                            <button type="submit" onclick="" class="btn btn--primary mb-2">{{translate('Save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('admin.business-settings.react-landing-page-settings', 'earning-seller-link') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h5 class="card-title mb-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{translate('Seller Section Content')}}</span>
                </h5>
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end">
                            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#section-1">
                                <strong class="mr-2">{{translate('See_the_changes_here.')}}</strong>
                                <div>
                                    <i class="tio-intersect"></i>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row g-3">
                            <div class="col-12">
                                @if ($language)
                            <div class="row g-3 lang_form default-form">
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Title')}} ({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_30_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="30" name="earning_seller_title[]" class="form-control" value="{{$earning_seller_title?->getRawOriginal('value')??''}}" placeholder="{{translate('messages.title_here...')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Sub Title')}} ({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_65_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="65" name="earning_seller_sub_title[]" class="form-control" value="{{$earning_seller_sub_title?->getRawOriginal('value')??''}}" placeholder="{{translate('messages.sub_title_here...')}}">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                @foreach(json_decode($language) as $lang)
                                <?php
                                if(isset($earning_seller_title->translations)&&count($earning_seller_title->translations)){
                                        $earning_seller_title_translate = [];
                                        foreach($earning_seller_title->translations as $t)
                                        {   
                                            if($t->locale == $lang && $t->key=='earning_seller_title'){
                                                $earning_seller_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                
                                    }
                                if(isset($earning_seller_sub_title->translations)&&count($earning_seller_sub_title->translations)){
                                        $earning_seller_sub_title_translate = [];
                                        foreach($earning_seller_sub_title->translations as $t)
                                        {   
                                            if($t->locale == $lang && $t->key=='earning_seller_sub_title'){
                                                $earning_seller_sub_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                
                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="{{$lang}}-form1">
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_30_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="30" name="earning_seller_title[]" class="form-control" value="{{ $earning_seller_title_translate[$lang]['value']?? '' }}" placeholder="{{translate('messages.title_here...')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Sub Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_65_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="65" name="earning_seller_sub_title[]" class="form-control" value="{{ $earning_seller_sub_title_translate[$lang]['value']?? '' }}" placeholder="{{translate('messages.sub_title_here...')}}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach
                            @else
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Title')}}</label>
                                        <input type="text" name="earning_seller_title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Sub Title')}}</label>
                                        <input type="text" name="earning_seller_sub_title[]" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            @endif
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title">
                                        <img src="{{asset('public/assets/admin/img/btn-cont.png')}}" class="mr-2" alt="">
                                        {{translate('Button Content')}}
                                    </h5>
                                </div>
                                <div class="__bg-F8F9FC-card">
                                    <div class="row">
                                        <div class="col-md-6">

                                            @if ($language)
                                                <div class="form-group lang_form default-form">
                                                    <label class="form-label text-capitalize">
                                                        {{translate('Button Name')}}({{ translate('messages.default') }})
                                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                    </span></label>
                                            <input type="text" maxlength="20" name="earning_seller_button_name[]" value="{{ $earning_seller_button_name?->getRawOriginal('value')??'' }}"  placeholder="{{translate('Ex: Order now')}}" class="form-control h--45px" value="">
                                                </div>
                                            @foreach(json_decode($language) as $lang)
                                            <?php
                                            if(isset($earning_seller_button_name->translations)&&count($earning_seller_button_name->translations)){
                                                    $earning_seller_button_name_translate = [];
                                                    foreach($earning_seller_button_name->translations as $t)
                                                    {   
                                                        if($t->locale == $lang && $t->key=='earning_seller_button_name'){
                                                            $earning_seller_button_name_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                            
                                                }
                                                ?>
                                                <div class="form-group d-none lang_form" id="{{$lang}}-form2">
                                                    <label class="form-label text-capitalize">
                                                        {{translate('Button Name')}}({{strtoupper($lang)}})
                                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                    </span></label>
                                            <input type="text" maxlength="20" name="earning_seller_button_name[]" value="{{ $earning_seller_button_name_translate[$lang]['value']??'' }}"  placeholder="{{translate('Ex: Order now')}}" class="form-control h--45px" value="">
                                                </div>
                                            @endforeach
                                        @else
                                        <div class="form-group">
                                            <label class="form-label text-capitalize">
                                                {{translate('Button Name')}}
                             {{-- <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum">
                                                    <i class="tio-info-outined"></i>
                                                </span> --}}
                                            </label>
                                            <input type="text" placeholder="{{translate('Ex: Order now')}}" class="form-control h--45px" name="earning_seller_button_name[]" value="">
                                        </div>
                                        @endif
                                        </div>
                                        <div class="col-md-6">
    
                                            <div class="form-group mb-md-0">
                                                <label class="form-label text-capitalize">
                                                    {{translate('Redirect Link')}}
                                                    <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('The_button_will_direct_users_to_the_link_contained_within_this_box.') }}">
                                                        <i class="tio-info-outined"></i>
                                                    </span>
                                                </label>
                                                <input type="text" placeholder="{{translate('Ex: https://www.apple.com/app-store/')}}" class="form-control h--45px" name="earning_seller_button_url" value="{{ $earning_seller_button_url['value']??'' }}">
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
            <form action="{{ route('admin.business-settings.react-landing-page-settings', 'earning-dm-link') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h5 class="card-title mt-3 mb-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{translate('Deliveryman_Section_Content')}}</span>
                </h5>
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end">
                            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#section-1">
                                <strong class="mr-2">{{translate('See_the_changes_here.')}}</strong>
                                <div>
                                    <i class="tio-intersect"></i>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row g-3">
                            <div class="col-12">
                                @if ($language)
                            <div class="row g-3 lang_form default-form">
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Title')}} ({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_30_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="30" name="earning_dm_title[]" class="form-control" value="{{$earning_dm_title?->getRawOriginal('value')??''}}" placeholder="{{translate('messages.title_here...')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Sub Title')}} ({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_65_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="65" name="earning_dm_sub_title[]" class="form-control" value="{{$earning_dm_sub_title?->getRawOriginal('value')??''}}" placeholder="{{translate('messages.sub_title_here...')}}">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                @foreach(json_decode($language) as $lang)
                                <?php
                                if(isset($earning_dm_title->translations)&&count($earning_dm_title->translations)){
                                        $earning_dm_title_translate = [];
                                        foreach($earning_dm_title->translations as $t)
                                        {   
                                            if($t->locale == $lang && $t->key=='earning_dm_title'){
                                                $earning_dm_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                
                                    }
                                if(isset($earning_dm_sub_title->translations)&&count($earning_dm_sub_title->translations)){
                                        $earning_dm_sub_title_translate = [];
                                        foreach($earning_dm_sub_title->translations as $t)
                                        {   
                                            if($t->locale == $lang && $t->key=='earning_dm_sub_title'){
                                                $earning_dm_sub_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                
                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="{{$lang}}-form3">
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_30_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="30" name="earning_dm_title[]" class="form-control" value="{{ $earning_dm_title_translate[$lang]['value']?? '' }}" placeholder="{{translate('messages.title_here...')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Sub Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_65_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="65" name="earning_dm_sub_title[]" class="form-control" value="{{ $earning_dm_sub_title_translate[$lang]['value']?? '' }}" placeholder="{{translate('messages.sub_title_here...')}}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach
                            @else
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Title')}}</label>
                                        <input type="text" name="earning_dm_title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Sub Title')}}</label>
                                        <input type="text" name="earning_dm_sub_title[]" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            @endif
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title">
                                        <img src="{{asset('public/assets/admin/img/btn-cont.png')}}" class="mr-2" alt="">
                                        {{translate('Button Content')}}
                                    </h5>
                                </div>
                                <div class="__bg-F8F9FC-card">
                                    <div class="row">
                                        <div class="col-md-6">

                                            @if ($language)
                                                <div class="form-group lang_form default-form">
                                                    <label class="form-label text-capitalize">
                                                        {{translate('Button Name')}}({{ translate('messages.default') }})
                                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                    </span></label>
                                            <input type="text" maxlength="20" name="earning_dm_button_name[]" value="{{ $earning_dm_button_name?->getRawOriginal('value')??'' }}"  placeholder="{{translate('Ex: Order now')}}" class="form-control h--45px" value="">
                                                </div>
                                            @foreach(json_decode($language) as $lang)
                                            <?php
                                            if(isset($earning_dm_button_name->translations)&&count($earning_dm_button_name->translations)){
                                                    $earning_dm_button_name_translate = [];
                                                    foreach($earning_dm_button_name->translations as $t)
                                                    {   
                                                        if($t->locale == $lang && $t->key=='earning_dm_button_name'){
                                                            $earning_dm_button_name_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                            
                                                }
                                                ?>
                                                <div class="form-group d-none lang_form" id="{{$lang}}-form4">
                                                    <label class="form-label text-capitalize">
                                                        {{translate('Button Name')}}({{strtoupper($lang)}})
                                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                    </span></label>
                                            <input type="text" maxlength="20" name="earning_dm_button_name[]" value="{{ $earning_dm_button_name_translate[$lang]['value']??'' }}"  placeholder="{{translate('Ex: Order now')}}" class="form-control h--45px" value="">
                                                </div>
                                            @endforeach
                                        @else
                                        <div class="form-group">
                                            <label class="form-label text-capitalize">
                                                {{translate('Button Name')}}
                             {{-- <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum">
                                                    <i class="tio-info-outined"></i>
                                                </span> --}}
                                            </label>
                                            <input type="text" placeholder="{{translate('Ex: Order now')}}" class="form-control h--45px" name="earning_dm_button_name[]" value="">
                                        </div>
                                        @endif
                                        </div>
                                        <div class="col-md-6">
    
                                            <div class="form-group mb-md-0">
                                                <label class="form-label text-capitalize">
                                                    {{translate('Redirect Link')}}
                                                    <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('The_button_will_direct_users_to_the_link_contained_within_this_box.') }}">
                                                        <i class="tio-info-outined"></i>
                                                    </span>
                                                </label>
                                                <input type="text" placeholder="{{translate('Ex: https://www.apple.com/app-store/')}}" class="form-control h--45px" name="earning_dm_button_url" value="{{ $earning_dm_button_url['value']??'' }}">
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
        
            <!-- Feature Modal -->
            <div class="modal fade" id="feature-modal">
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
                                        <img src="{{asset('/public/assets/admin/img/modal/feature-list-off.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning OFF ')}} <strong>{{translate('Feature List Section')}}</strong></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('Feature list will be disabled. You can enable it in the settings to access its features and functionality')}}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div>
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/feature-list-on.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning ON ')}} <strong>{{translate('Feature List Section')}}</strong></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('Feature list is enabled. You can now access its features and functionality')}}
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
        
            <!-- Module Setup Section View -->
            <div class="modal fade" id="admin-earn-money">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3">{{translate('Admin Earn Money')}}</h3>
                            </div>
                            <img src="{{asset('/public/assets/admin/img/zone-instruction.png')}}" alt="admin/img" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Module Setup Section View -->
            <div class="modal fade" id="section-1">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3">{{translate('Download Seller App Section')}}</h3>
                            </div>
                            <img src="{{asset('/public/assets/admin/img/zone-instruction.png')}}" alt="admin/img" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Module Setup Section View -->
            <div class="modal fade" id="section-2">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3">{{translate('Download Delivery Man App Section ')}}</h3>
                            </div>
                            <img src="{{asset('/public/assets/admin/img/zone-instruction.png')}}" alt="admin/img" class="w-100">
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
        $("#"+lang+"-form2").removeClass('d-none');
        $("#"+lang+"-form3").removeClass('d-none');
        $("#"+lang+"-form4").removeClass('d-none');
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
