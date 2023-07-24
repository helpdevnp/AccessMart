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
    @php($contact_us_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','contact_us_title')->first())
    @php($contact_us_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','contact_us_sub_title')->first())
    @php($contact_us_image=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','contact_us_image')->first())
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
            <form action="{{ route('admin.business-settings.admin-landing-page-settings', 'contact-us-section') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
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
                                <input type="text" maxlength="20" name="contact_us_title[]" value="{{ $contact_us_title?->getRawOriginal('value') }}" class="form-control" placeholder="{{translate('Ex_:_Contact_Us')}}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Sub Title')}} ({{ translate('messages.default') }})<span
                                        class="form-label-secondary" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                            alt="">
                                    </span></label>
                                <input type="text" maxlength="80" name="contact_us_sub_title[]" value="{{ $contact_us_sub_title?->getRawOriginal('value') }}" class="form-control" placeholder="{{translate('Ex_:_Any_questions_or_remarks_?_Just_write_us_a_message!')}}">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                    @foreach(json_decode($language) as $lang)
                                    <?php
                                    if(isset($contact_us_title->translations)&&count($contact_us_title->translations)){
                                            $contact_us_title_translate = [];
                                            foreach($contact_us_title->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='contact_us_title'){
                                                    $contact_us_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                    
                                        }
                                    if(isset($contact_us_sub_title->translations)&&count($contact_us_sub_title->translations)){
                                            $contact_us_sub_title_translate = [];
                                            foreach($contact_us_sub_title->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='contact_us_sub_title'){
                                                    $contact_us_sub_title_translate[$lang]['value'] = $t->value;
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
                                <input type="text" maxlength="20" name="contact_us_title[]" value="{{ $contact_us_title_translate[$lang]['value']??'' }}" class="form-control" placeholder="{{translate('Ex_:_Contact_Us')}}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">{{translate('Sub Title')}} ({{strtoupper($lang)}})<span
                                        class="form-label-secondary" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                            alt="">
                                    </span></label>
                                <input type="text" maxlength="80" name="contact_us_sub_title[]" value="{{ $contact_us_sub_title_translate[$lang]['value']??'' }}" class="form-control" placeholder="{{translate('Ex_:_Any_questions_or_remarks_?_Just_write_us_a_message!')}}">
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
                                <input type="text" maxlength="20" name="contact_us_title[]" class="form-control" placeholder="{{translate('Ex_:_Contact_Us')}}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">{{translate('Sub Title')}}<span
                                        class="form-label-secondary" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                            alt="">
                                    </span></label>
                                <input type="text" maxlength="80" name="contact_us_sub_title[]" class="form-control" placeholder="{{translate('Ex_:_Any_questions_or_remarks_?_Just_write_us_a_message!')}}">
                                        </div>
                                    </div>
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                @endif
                            </div>
                            <div class="col-md-6">
                                    <label class="form-label d-block mb-2">
                                        {{ translate('messages.Banner') }}  <span class="text--primary">(size: 6:1)</span>
                                    </label>
                                    <label class="upload-img-3 m-0 d-block">
                                        <div class="position-relative">
                                        <div class="img">
                                            <img src="{{asset('storage/app/public/contact_us_image')}}/{{ $contact_us_image['value']??'' }}" class="vertical-img mw-100" alt="" onerror="this.src='{{asset("public/assets/admin/img/upload-4.png")}}'">
                                        </div>
                                          <input type="file"  name="image" hidden="">
                                          @if (isset($contact_us_image['value']))
                                            <span id="contact_image" class="remove_image_button"
                                                onclick="toogleStatusModal(event,'contact_image','mail-success','mail-warning','{{translate('Important!')}}','{{translate('Warning!')}}',`<p>{{translate('Are_you_sure_you_want_to_remove_this_image')}}</p>`,`<p>{{translate('Are_you_sure_you_want_to_remove_this_image.')}}</p>`)"
                                                > <i class="tio-clear"></i></span>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                        </div>
                    </div>
                </div>
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-poi"></i></span> <span>{{translate('Office Opening & Closing')}}</span>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-6 col-lg-3">
                                @php($opening_time = \App\Models\BusinessSetting::where('key', 'opening_time')->first())
                                <label class="form-label">{{translate('Start Time')}}</label>
                                <input type="time" value="{{ $opening_time ? $opening_time->value: '' }}" name="opening_time" class="form-control" id="opening_time">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                 @php($closing_time = \App\Models\BusinessSetting::where('key', 'closing_time')->first())
                                <label class="form-label">{{translate('End Time')}}</label>
                                <input type="time" value="{{ $closing_time ? $closing_time->value: '' }}" name="closing_time" class="form-control" id="closing_time">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                @php($opening_day = \App\Models\BusinessSetting::where('key', 'opening_day')->first())
                                @php($opening_day = $opening_day ? $opening_day->value : '')
                                <label class="form-label">{{translate('Start Day')}}</label>
                                <select name="opening_day" class="form-control">
                                    <option value="saturday" {{ $opening_day == 'saturday' ? 'selected' : '' }}>
                                        {{ translate('messages.saturday') }}
                                    </option>
                                    <option value="sunday" {{ $opening_day == 'sunday' ? 'selected' : '' }}>
                                        {{ translate('messages.sunday') }}
                                    </option>
                                    <option value="monday" {{ $opening_day == 'monday' ? 'selected' : '' }}>
                                        {{ translate('messages.monday') }}
                                    </option>
                                    <option value="tuesday" {{ $opening_day == 'tuesday' ? 'selected' : '' }}>
                                        {{ translate('messages.tuesday') }}
                                    </option>
                                    <option value="wednesday" {{ $opening_day == 'wednesday' ? 'selected' : '' }}>
                                        {{ translate('messages.wednesday') }}
                                    </option>
                                    <option value="thrusday" {{ $opening_day == 'thrusday' ? 'selected' : '' }}>
                                        {{ translate('messages.thrusday') }}
                                    </option>
                                    <option value="friday" {{ $opening_day == 'friday' ? 'selected' : '' }}>
                                        {{ translate('messages.friday') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                @php($closing_day = \App\Models\BusinessSetting::where('key', 'closing_day')->first())
                                @php($closing_day = $closing_day ? $closing_day->value : '')
                                <label class="form-label">{{translate('End Day')}}</label>
                                <select name="closing_day" class="form-control">
                                    <option value="saturday" {{ $closing_day == 'saturday' ? 'selected' : '' }}>
                                        {{ translate('messages.saturday') }}
                                    </option>
                                    <option value="sunday" {{ $closing_day == 'sunday' ? 'selected' : '' }}>
                                        {{ translate('messages.sunday') }}
                                    </option>
                                    <option value="monday" {{ $closing_day == 'monday' ? 'selected' : '' }}>
                                        {{ translate('messages.monday') }}
                                    </option>
                                    <option value="tuesday" {{ $closing_day == 'tuesday' ? 'selected' : '' }}>
                                        {{ translate('messages.tuesday') }}
                                    </option>
                                    <option value="wednesday" {{ $closing_day == 'wednesday' ? 'selected' : '' }}>
                                        {{ translate('messages.wednesday') }}
                                    </option>
                                    <option value="thrusday" {{ $closing_day == 'thrusday' ? 'selected' : '' }}>
                                        {{ translate('messages.thrusday') }}
                                    </option>
                                    <option value="friday" {{ $closing_day == 'friday' ? 'selected' : '' }}>
                                        {{ translate('messages.friday') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end mt-3">
                    <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                    <button type="submit" onclick="" class="btn btn--primary mb-2">{{translate('Save Information')}}</button>
                </div>
            </form>
            <form  id="contact_image_form" action="{{ route('admin.remove_image') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{  $contact_us_image?->id}}" >
                {{-- <input type="hidden" name="json" value="1" > --}}
                <input type="hidden" name="model_name" value="DataSetting" >
                <input type="hidden" name="image_path" value="contact_us_image" >
                <input type="hidden" name="field_name" value="value" >
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
