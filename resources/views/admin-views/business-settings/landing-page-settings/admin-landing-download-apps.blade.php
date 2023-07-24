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
    @php($counter = \App\Models\DataSetting::where(['key'=>'counter_section','type'=>'admin_landing_page'])->first())
    @php($counter = isset($counter->value)?json_decode($counter->value, true):null)
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <form action="{{ route('admin.business-settings.admin-landing-page-settings', 'download-counter-section') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h5 class="card-title mb-3 mt-3">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span>
                            <span class="card-header-icon mr-2">
                                <i class="tio-settings-outlined"></i>
                            </span>
                            <span>{{translate('Counter Section')}}</span>
                        </span>
                        <label class="toggle-switch toggle-switch-sm m-0">
                            <input type="checkbox" name="status" onclick="toogleModal(event,'counter_status','counter-on.png','counter-off.png','{{translate('By Turning ON Counter Section')}}','{{translate('By Turning OFF Counter Section')}}',`<p>{{translate('Counter Section is enabled. You can now access its features and functionality')}}</p>`,`<p>{{translate('Counter section will be disabled. You can enable it in the settings to access its features and functionality')}}</p>`)" id="counter_status" class="status toggle-switch-input" value="1" {{(isset($counter) && $counter['status'])?'checked':''}}>
                            <span class="toggle-switch-label text mb-0">
                                <span class="toggle-switch-indicator"></span>
                            </span>
                        </label>
                    </div>
                </h5>
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end">
                            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#download_apps_section">
                                <strong class="mr-2">{{translate('See_the_changes_here.')}}</strong>
                                <div>
                                    <i class="tio-intersect"></i>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row g-3">
                            <div class="col-sm-6 col-lg-3">
                                <label class="form-label">{{translate('Total App Download')}}</label>
                                <input type="number" min="0" max="9999999999" name="app_download_count_numbers" value="{{ $counter['app_download_count_numbers'] ?? '' }}" placeholder="{{translate('Ex: 500')}}" class="form-control">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <label class="form-label">{{translate('Total Seller')}}</label>
                                <input type="number" min="0" max="9999999999" name="seller_count_numbers" value="{{ $counter['seller_count_numbers'] ?? '' }}" placeholder="{{translate('Ex: 500')}}" class="form-control">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <label class="form-label">{{translate('Total Delivery Man')}}</label>
                                <input type="number" min="0" max="9999999999" name="deliveryman_count_numbers" value="{{ $counter['deliveryman_count_numbers'] ?? '' }}" placeholder="{{translate('Ex: 500')}}" class="form-control">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <label class="form-label">{{translate('Total Customer')}}</label>
                                <input type="number" min="0" max="9999999999" name="customer_count_numbers" value="{{ $counter['customer_count_numbers'] ?? '' }}" placeholder="{{translate('Ex: 500')}}" class="form-control">
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-3">
                            <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                            <button type="submit" onclick="" class="btn btn--primary mb-2">{{translate('Save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
            @php($download_user_app_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','download_user_app_title')->first())
            @php($download_user_app_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','download_user_app_sub_title')->first())
            @php($download_user_app_image=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','download_user_app_image')->first())
            @php($download_user_app_links = \App\Models\DataSetting::where(['key'=>'download_user_app_links','type'=>'admin_landing_page'])->first())
            @php($download_user_app_links = isset($download_user_app_links->value)?json_decode($download_user_app_links->value, true):null)
            <form action="{{ route('admin.business-settings.admin-landing-page-settings', 'download-app-section') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{translate('Download User App Section Content')}}</span>
                </h5>
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end">
                            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#download_apps_section">
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
                                            <label class="form-label">{{translate('Title')}} ({{ translate('messages.default') }})<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="20" name="download_user_app_title[]" value="{{ $download_user_app_title?->getRawOriginal('value') }}" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Sub Title')}} ({{ translate('messages.default') }})<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="50" name="download_user_app_sub_title[]" value="{{ $download_user_app_sub_title?->getRawOriginal('value') }}" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                    @foreach(json_decode($language) as $lang)
                                    <?php
                                    if(isset($download_user_app_title->translations)&&count($download_user_app_title->translations)){
                                            $download_user_app_title_translate = [];
                                            foreach($download_user_app_title->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='download_user_app_title'){
                                                    $download_user_app_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                    
                                        }
                                    if(isset($download_user_app_sub_title->translations)&&count($download_user_app_sub_title->translations)){
                                            $download_user_app_sub_title_translate = [];
                                            foreach($download_user_app_sub_title->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='download_user_app_sub_title'){
                                                    $download_user_app_sub_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                    
                                        }
                                        ?>
                                    <div class="col-md-12 d-none lang_form" id="{{$lang}}-form1">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">{{translate('Title')}} ({{strtoupper($lang)}})<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="20" name="download_user_app_title[]" value="{{ $download_user_app_title_translate[$lang]['value']??'' }}" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">{{translate('Sub Title')}} ({{strtoupper($lang)}})<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="50" name="download_user_app_sub_title[]" value="{{ $download_user_app_sub_title_translate[$lang]['value']??'' }}" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                            </div>
                                        </div>
                                    </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                    @endforeach
                                @else
                                <div class="col-md-12">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Title')}}<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="20" name="download_user_app_title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Sub Title')}}<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="50" name="download_user_app_sub_title[]" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
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
                                        <img src="{{asset('storage/app/public/download_user_app_image')}}/{{ $download_user_app_image['value']??'' }}" onerror='this.src="{{asset('/public/assets/admin/img/aspect-1.png')}}"' alt="" class="img__aspect-1 min-w-187px max-w-187px">
                                    </div>
                                      <input type="file"  name="image" hidden>
                                            @if (isset($download_user_app_image['value']))
                                            <span id="download_user_app_image" class="remove_image_button"
                                                onclick="toogleStatusModal(event,'download_user_app_image','mail-success','mail-warning','{{translate('Important!')}}','{{translate('Warning!')}}',`<p>{{translate('Are_you_sure_you_want_to_remove_this_image')}}</p>`,`<p>{{translate('Are_you_sure_you_want_to_remove_this_image.')}}</p>`)"
                                                > <i class="tio-clear"></i></span>
                                            @endif
                                        </div>
                                </label>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
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
                                                <input type="checkbox" name="playstore_url_status" onclick="toogleModal(event,'play-store-dm-status','play-store-on.png','play-store-off.png','{{translate('Playstore Button Enabled for Delivery Man')}}','{{translate('Playstore Button Disabled for Delivery Man')}}',`<p>{{translate('Playstore button is enabled now everyone can use or see the button')}}</p>`,`<p>{{translate('Playstore button is disabled now no one can use or see the button')}}</p>`)" id="play-store-dm-status" class="status toggle-switch-input" value="1" {{(isset($download_user_app_links) && $download_user_app_links['playstore_url_status'])?'checked':''}}>
                                                <span class="toggle-switch-label text mb-0">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <input type="text" placeholder="{{translate('Ex: https://play.google.com/store/apps')}}" class="form-control h--45px" name="playstore_url" value="{{isset($download_user_app_links['playstore_url']) ? $download_user_app_links['playstore_url']:''}}">
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
                                                <input type="checkbox" name="apple_store_url_status" onclick="toogleModal(event,'apple-dm-status','apple-on.png','apple-off.png','{{translate('App Store Button Enabled for Delivery Man')}}','{{translate('App Store Button Disabled for Delivery Man')}}',`<p>{{translate('App Store button is enabled now everyone can use or see the button')}}</p>`,`<p>{{translate('App Store button is disabled now no one can use or see the button')}}</p>`)" id="apple-dm-status" class="status toggle-switch-input" value="1" {{(isset($download_user_app_links) && $download_user_app_links['apple_store_url_status'])?'checked':''}}>
                                                <span class="toggle-switch-label text mb-0">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <input type="text" placeholder="{{translate('Ex: https://www.apple.com/app-store/')}}" class="form-control h--45px" name="apple_store_url" value="{{isset($download_user_app_links['apple_store_url']) ? $download_user_app_links['apple_store_url']:''}}">
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
             <form  id="download_user_app_image_form" action="{{ route('admin.remove_image') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{  $download_user_app_image?->id}}" >
                {{-- <input type="hidden" name="json" value="1" > --}}
                <input type="hidden" name="model_name" value="DataSetting" >
                <input type="hidden" name="image_path" value="download_user_app_image" >
                <input type="hidden" name="field_name" value="value" >
            </form> 
            <!-- Module Setup Section View -->
            <div class="modal fade" id="download_apps_section">
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
