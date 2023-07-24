@extends('layouts.admin.app')

@section('title',translate('messages.admin_landing_page'))

@section('content')
<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/landing.png')}}" class="w--20" alt="">
                </span>
                <span>
                    {{ translate('messages.admin_landing_pages') }}
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
            @include('admin-views.business-settings.landing-page-settings.top-menu-links.admin-landing-page-links')
        </div>
    </div>
    @php($fixed_header_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_header_title')->first())
    @php($fixed_header_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_header_sub_title')->first())
    @php($fixed_module_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_module_title')->first())
    @php($fixed_module_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_module_sub_title')->first())
    @php($fixed_referal_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_referal_title')->first())
    @php($fixed_referal_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_referal_sub_title')->first())
    @php($fixed_newsletter_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_newsletter_title')->first())
    @php($fixed_newsletter_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_newsletter_sub_title')->first())
    @php($fixed_footer_article_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_footer_article_title')->first())
    @php($fixed_link = \App\Models\DataSetting::where(['key'=>'fixed_link','type'=>'admin_landing_page'])->first())
    @php($fixed_link = isset($fixed_link->value)?json_decode($fixed_link->value, true):null)
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
            <form action="{{ route('admin.business-settings.admin-landing-page-settings', 'fixed-data') }}" method="POST">
                @csrf
                @if ($language)
                <div class="lang_form"  id="default-form">
                    <h5 class="card-title mb-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('messages.header_section')}} ({{ translate('messages.default') }})</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="50" name="fixed_header_title[]" value="{{$fixed_header_title?->getRawOriginal('value')}}" class="form-control" placeholder="{{translate('Ex_:_Manage_your_daily_life_on_one_platform')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_100_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="100" name="fixed_header_sub_title[]" value="{{$fixed_header_sub_title?->getRawOriginal('value')}}" class="form-control" placeholder="{{translate('Ex_:_More_than_just_a_reliable_eCommerce_platform')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-3 mt-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('messages.module_list_section')}} ({{ translate('messages.default') }})</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="50" name="fixed_module_title[]" value="{{$fixed_module_title?->getRawOriginal('value')}}" class="form-control" placeholder="{{translate('Ex_:_Your_eCommerce_venture_starts_here')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_100_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="100" name="fixed_module_sub_title[]" value="{{$fixed_module_sub_title?->getRawOriginal('value')}}" class="form-control" placeholder="{{translate('Ex_:_Enjoy_all_services_in_one_platform')}}">
                                </div>
                            </div>
                            <div class="alert alert-warning d-flex mt-4 mb-0">
                                <div class="alert--icon">
                                    <i class="tio-info"></i>
                                </div>
                                <div>
                                    {{translate('NB_:_All_the_modules_and_their_information_will_be_dynamically_added_from_the_module_setup_section._You_just_need_to_add_the_title_and_subtitle_of_the_Module_List_Section.')}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-3 mt-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('Referral & Earning')}} ({{ translate('messages.default') }})</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            {{-- <div class="d-flex justify-content-end">
                                <div class="blinkings d-block">
                                    <i class="tio-info-outined"></i>
                                    <div class="business-notes">
                                        <h6><img src="{{asset('public/assets/admin/img/notes.png')}}" alt=""> {{translate('Note')}}</h6>
                                        <div>
                                            {{translate('To Change the illustrations & primary colour please change primary colour according to the ')}}
                                        </div>
                                        <a href="#" class="text-underline text-info">documentation</a>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_40_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="40" name="fixed_referal_title[]" value="{{$fixed_referal_title?->getRawOriginal('value')}}" class="form-control" placeholder="{{translate('Ex_:_Earn_Point')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_80_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="80" name="fixed_referal_sub_title[]" value="{{$fixed_referal_sub_title?->getRawOriginal('value')}}" class="form-control" placeholder="{{translate('Ex_:_By_referring_your_friend')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-3 mt-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('newsletter')}} ({{ translate('messages.default') }})</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_40_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="40" name="fixed_newsletter_title[]" value="{{$fixed_newsletter_title?->getRawOriginal('value')}}" class="form-control" placeholder="{{translate('Ex_:_Sign_Up_to_Our_Newsletter')}}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_80_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="80" name="fixed_newsletter_sub_title[]" value="{{$fixed_newsletter_sub_title?->getRawOriginal('value')}}" class="form-control" placeholder="{{translate('Ex_:_Receive_Latest_News,_Updates_and_Many_Other_News_Every_Week')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-3 mt-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('Footer_Article')}} ({{ translate('messages.default') }})</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_180_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="180" name="fixed_footer_article_title[]" value="{{$fixed_footer_article_title?->getRawOriginal('value')}}" class="form-control" placeholder="{{translate('Ex_:_6amMart_is_a_complete_package!__It`s_time_to_empower_your_multivendor_online_business_with__powerful_features!')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="lang[]" value="default">
                    @foreach(json_decode($language) as $lang)
                    <?php
                    if(isset($fixed_header_title->translations)&&count($fixed_header_title->translations)){
                            $fixed_header_title_translate = [];
                            foreach($fixed_header_title->translations as $t)
                            {   
                                if($t->locale == $lang && $t->key=='fixed_header_title'){
                                    $fixed_header_title_translate[$lang]['value'] = $t->value;
                                }
                            }
                    
                        }
                    if(isset($fixed_header_sub_title->translations)&&count($fixed_header_sub_title->translations)){
                            $fixed_header_sub_title_translate = [];
                            foreach($fixed_header_sub_title->translations as $t)
                            {   
                                if($t->locale == $lang && $t->key=='fixed_header_sub_title'){
                                    $fixed_header_sub_title_translate[$lang]['value'] = $t->value;
                                }
                            }
                    
                        }
                    if(isset($fixed_module_title->translations)&&count($fixed_module_title->translations)){
                            $fixed_module_title_translate = [];
                            foreach($fixed_module_title->translations as $t)
                            {   
                                if($t->locale == $lang && $t->key=='fixed_module_title'){
                                    $fixed_module_title_translate[$lang]['value'] = $t->value;
                                }
                            }
                    
                        }
                    if(isset($fixed_module_sub_title->translations)&&count($fixed_module_sub_title->translations)){
                            $fixed_module_sub_title_translate = [];
                            foreach($fixed_module_sub_title->translations as $t)
                            {   
                                if($t->locale == $lang && $t->key=='fixed_module_sub_title'){
                                    $fixed_module_sub_title_translate[$lang]['value'] = $t->value;
                                }
                            }
                    
                        }
                    if(isset($fixed_referal_title->translations)&&count($fixed_referal_title->translations)){
                            $fixed_referal_title_translate = [];
                            foreach($fixed_referal_title->translations as $t)
                            {   
                                if($t->locale == $lang && $t->key=='fixed_referal_title'){
                                    $fixed_referal_title_translate[$lang]['value'] = $t->value;
                                }
                            }
                    
                        }
                    if(isset($fixed_referal_sub_title->translations)&&count($fixed_referal_sub_title->translations)){
                            $fixed_referal_sub_title_translate = [];
                            foreach($fixed_referal_sub_title->translations as $t)
                            {   
                                if($t->locale == $lang && $t->key=='fixed_referal_sub_title'){
                                    $fixed_referal_sub_title_translate[$lang]['value'] = $t->value;
                                }
                            }
                    
                        }
                    if(isset($fixed_newsletter_title->translations)&&count($fixed_newsletter_title->translations)){
                            $fixed_newsletter_title_translate = [];
                            foreach($fixed_newsletter_title->translations as $t)
                            {   
                                if($t->locale == $lang && $t->key=='fixed_newsletter_title'){
                                    $fixed_newsletter_title_translate[$lang]['value'] = $t->value;
                                }
                            }
                    
                        }
                    if(isset($fixed_newsletter_sub_title->translations)&&count($fixed_newsletter_sub_title->translations)){
                            $fixed_newsletter_sub_title_translate = [];
                            foreach($fixed_newsletter_sub_title->translations as $t)
                            {   
                                if($t->locale == $lang && $t->key=='fixed_newsletter_sub_title'){
                                    $fixed_newsletter_sub_title_translate[$lang]['value'] = $t->value;
                                }
                            }
                    
                        }
                    if(isset($fixed_footer_article_title->translations)&&count($fixed_footer_article_title->translations)){
                        $fixed_footer_article_title_translate = [];
                        foreach($fixed_footer_article_title->translations as $t)
                        {   
                            if($t->locale == $lang && $t->key=='fixed_footer_article_title'){
                                $fixed_footer_article_title_translate[$lang]['value'] = $t->value;
                            }
                        }
                
                    }
                    ?>
                        <div class="d-none lang_form" id="{{$lang}}-form">
                            <h5 class="card-title mb-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('messages.header_section')}} ({{strtoupper($lang)}})</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                            <input type="text"  maxlength="50" name="fixed_header_title[]" value="{{$fixed_header_title_translate[$lang]['value']??''}}" class="form-control" placeholder="{{translate('Ex_:_Manage_your_daily_life_on_one_platform')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_100_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                            <input type="text"  maxlength="100" name="fixed_header_sub_title[]" value="{{$fixed_header_sub_title_translate[$lang]['value']??''}}" class="form-control" placeholder="{{translate('Ex_:_More_than_just_a_reliable_eCommerce_platform')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('messages.module_list_section')}} ({{strtoupper($lang)}})</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                            <input type="text"  maxlength="50" name="fixed_module_title[]" value="{{$fixed_module_title_translate[$lang]['value']??''}}" class="form-control" placeholder="{{translate('Ex_:_Your_eCommerce_venture_starts_here')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_100_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                            <input type="text"  maxlength="100" name="fixed_module_sub_title[]" value="{{$fixed_module_sub_title_translate[$lang]['value']??''}}" class="form-control" placeholder="{{translate('Ex_:_Enjoy_all_services_in_one_platform')}}">
                                        </div>
                                    </div>
                                    <div class="alert alert-warning d-flex mt-4 mb-0">
                                        <div class="alert--icon">
                                            <i class="tio-info"></i>
                                        </div>
                                        <div>
                                            {{translate('NB_:_All_the_modules_and_their_information_will_be_dynamically_added_from_the_module_setup_section._You_just_need_to_add_the_title_and_subtitle_of_the_Module_List_Section.')}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('Referral & Earning')}} ({{strtoupper($lang)}})</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    {{-- <div class="d-flex justify-content-end">
                                        <div class="blinkings d-block">
                                            <i class="tio-info-outined"></i>
                                            <div class="business-notes">
                                                <h6><img src="{{asset('public/assets/admin/img/notes.png')}}" alt=""> {{translate('Note')}}</h6>
                                                <div>
                                                    {{translate('To Change the illustrations & primary colour please change primary colour according to the ')}}
                                                </div>
                                                <a href="#" class="text-underline text-info">documentation</a>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_40_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                            <input type="text"  maxlength="40" name="fixed_referal_title[]" value="{{$fixed_referal_title_translate[$lang]['value']??''}}" class="form-control" placeholder="{{translate('Ex_:_Earn_Point')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_80_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                            <input type="text"  maxlength="80" name="fixed_referal_sub_title[]" value="{{$fixed_referal_sub_title_translate[$lang]['value']??''}}" class="form-control" placeholder="{{translate('Ex_:_By_referring_your_friend')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('newsletter')}} ({{strtoupper($lang)}})</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_40_characters') }}">
                                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                    </span></label>
                                            <input type="text"  maxlength="40" name="fixed_newsletter_title[]" value="{{$fixed_newsletter_title_translate[$lang]['value']??''}}" class="form-control" placeholder="{{translate('Ex_:_Sign_Up_to_Our_Newsletter')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_80_characters') }}">
                                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                    </span></label>
                                            <input type="text"  maxlength="80" name="fixed_newsletter_sub_title[]" value="{{$fixed_newsletter_sub_title_translate[$lang]['value']??''}}" class="form-control" placeholder="{{translate('Ex_:_Receive_Latest_News,_Updates_and_Many_Other_News_Every_Week')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('Footer_Article')}} ({{strtoupper($lang)}})</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_180_characters') }}">
                                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                    </span></label>
                                            <input type="text"  maxlength="180" name="fixed_footer_article_title[]" value="{{$fixed_footer_article_title_translate[$lang]['value']??''}}" class="form-control" placeholder="{{translate('Ex_:_6amMart_is_a_complete_package!__It`s_time_to_empower_your_multivendor_online_business_with__powerful_features!')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="lang[]" value="{{$lang}}">
                    @endforeach
                @else
                    <div>
                        <h5 class="card-title mb-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('messages.header_section')}}</span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                        <input type="text"  maxlength="50" name="fixed_header_title[]" class="form-control" placeholder="{{translate('Ex_:_Manage_your_daily_life_on_one_platform')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                        <input type="text"  maxlength="50" name="fixed_header_sub_title[]" class="form-control" placeholder="{{translate('Ex_:_More_than_just_a_reliable_eCommerce_platform')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-3 mt-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('messages.module_list_section')}}</span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                        <input type="text"  maxlength="50" name="fixed_module_title[]" class="form-control" placeholder="{{translate('Ex_:_Your_eCommerce_venture_starts_here')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                        <input type="text"  maxlength="50" name="fixed_module_sub_title[]" class="form-control" placeholder="{{translate('Ex_:_Enjoy_all_services_in_one_platform')}}">
                                    </div>
                                </div>
                                <div class="alert alert-warning d-flex mt-4 mb-0">
                                    <div class="alert--icon">
                                        <i class="tio-info"></i>
                                    </div>
                                    <div>
                                        {{translate('NB_:_All_the_modules_and_their_information_will_be_dynamically_added_from_the_module_setup_section._You_just_need_to_add_the_title_and_subtitle_of_the_Module_List_Section.')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-3 mt-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('Referral & Earning')}}</span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                {{-- <div class="d-flex justify-content-end">
                                    <div class="blinkings d-block">
                                        <i class="tio-info-outined"></i>
                                        <div class="business-notes">
                                            <h6><img src="{{asset('public/assets/admin/img/notes.png')}}" alt=""> {{translate('Note')}}</h6>
                                            <div>
                                                {{translate('To Change the illustrations & primary colour please change primary colour according to the ')}}
                                            </div>
                                            <a href="#" class="text-underline text-info">documentation</a>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                        <input type="text"  maxlength="50" name="fixed_referal_title[]" class="form-control" placeholder="{{translate('Ex_:_Earn_Point')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                        <input type="text"  maxlength="50" name="fixed_referal_sub_title[]" class="form-control" placeholder="{{translate('Ex_:_By_referring_your_friend')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-3 mt-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('newsletter')}} ({{ translate('messages.default') }})</span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                    <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                </span></label>
                                        <input type="text"  maxlength="50" name="fixed_newsletter_title[]" class="form-control" placeholder="{{translate('Ex_:_Sign_Up_to_Our_Newsletter')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">{{translate('Sub Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_sub_title_within_50_characters') }}">
                                                    <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                </span></label>
                                        <input type="text"  maxlength="50" name="fixed_newsletter_sub_title[]"  class="form-control" placeholder="{{translate('Ex_:_Receive_Latest_News,_Updates_and_Many_Other_News_Every_Week')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-3 mt-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span>{{translate('Footer_Article')}} ({{ translate('messages.default') }})</span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                    <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                </span></label>
                                        <input type="text"  maxlength="50" name="fixed_footer_article_title[]"  class="form-control" placeholder="{{translate('Ex_:_6amMart_is_a_complete_package!__It`s_time_to_empower_your_multivendor_online_business_with__powerful_features!')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="lang[]" value="default">
                @endif
                <h5 class="card-title card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span>
                    <span>{{translate('Browse Web Button')}}</span>
                </h5>
                <div class="card">
                    <div class="__bg-F8F9FC-card">
                        <div class="form-group mb-md-0">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label text-capitalize m-0">
                                    {{translate('Web Link')}}
                                    {{-- <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum">
                                        <i class="tio-info-outined"></i>
                                    </span> --}}
                                </label>
                                <label class="toggle-switch toggle-switch-sm m-0">
                                    <input type="checkbox" name="web_app_url_status" onclick="toogleModal(event,'apple-dm-status','apple-on.png','apple-off.png','{{translate('Browse Web Button Enabled for Landing Page')}}','{{translate('Browse Web Button Disabled for Landing Page')}}',`<p>{{translate('Browse Web button is enabled now everyone can use or see the button')}}</p>`,`<p>{{translate('Browse Web button is disabled now no one can use or see the button')}}</p>`)" id="apple-dm-status" class="status toggle-switch-input" value="1" {{(isset($fixed_link) && $fixed_link['web_app_url_status'])?'checked':''}}>
                                    <span class="toggle-switch-label text mb-0">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </div>
                            <input type="text" placeholder="{{translate('Ex: https://6ammart-web.6amtech.com/')}}" class="form-control h--45px" name="web_app_url" value="{{isset($fixed_link['web_app_url']) ? $fixed_link['web_app_url']:''}}">
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end mt-3">
                    <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                    <button type="submit" class="btn btn--primary mb-2">{{translate('Save Information')}}</button>
                </div>
            </form>
            <!-- Module Setup Section View -->
            <div class="modal fade" id="section-view">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3">{{translate('Referral & Earning')}}</h3>
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
    @include('admin-views.business-settings.landing-page-settings.partial.how-it-work')
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
        if(lang == '{{$default_lang}}')
        {
            $(".from_part_2").removeClass('d-none');
        }
        else
        {
            $(".from_part_2").addClass('d-none');
        }
    });
</script>
@endpush
