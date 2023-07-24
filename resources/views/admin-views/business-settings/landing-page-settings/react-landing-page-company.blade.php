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
    
    @php($company_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_title')->first())
    @php($company_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_sub_title')->first())
    @php($company_description=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_description')->first())
    @php($company_button_name=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_button_name')->first())
    @php($company_button_url=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_button_url')->first())
    
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
            <form action="{{ route('admin.business-settings.react-landing-page-settings', 'company-section') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h5 class="card-title mb-3 mt-3">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span>
                            <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{translate('Company Section')}}</span>
                        </span>
                    </div>
                </h5>
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end">
                            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center py-1" type="button" data-toggle="modal" data-target="#header-section">
                                <strong class="mr-2">{{translate('See_the_changes_here.')}}</strong>
                                <div>
                                    <i class="tio-intersect"></i>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="row g-3">
                                    @if ($language)
                                    <div class="col-12 lang_form default-form">
                                        <div class="mb-2">
                                            <label class="form-label">{{translate('Title')}}({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="20" name="company_title[]" value="{{ $company_title?->getRawOriginal('value')??'' }}" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">{{translate('Sub Title')}}({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_40_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="40" name="company_sub_title[]" value="{{ $company_sub_title?->getRawOriginal('value')??'' }}" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">
                                                {{translate('Short Description')}}({{ translate('messages.default') }})
                                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_240_characters') }}">
                                                    <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                </span></label>
                                            <textarea maxlength="240" name="company_description[]" class="form-control h--90px">{{ $company_description['value']??'' }}</textarea>
                                        </div>
                                    </div>
                                <input type="hidden" name="lang[]" value="default">
                                    @foreach(json_decode($language) as $lang)
                                    <?php
                                    if(isset($company_title->translations)&&count($company_title->translations)){
                                            $company_title_translate = [];
                                            foreach($company_title->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='company_title'){
                                                    $company_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                    
                                        }
                                    if(isset($company_sub_title->translations)&&count($company_sub_title->translations)){
                                            $company_sub_title_translate = [];
                                            foreach($company_sub_title->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='company_sub_title'){
                                                    $company_sub_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                    
                                        }
                                    if(isset($company_description->translations)&&count($company_description->translations)){
                                            $company_description_translate = [];
                                            foreach($company_description->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='company_description'){
                                                    $company_description_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                    
                                        }
                                        ?>
                                        <div class="col-12 d-none lang_form" id="{{$lang}}-form">
                                            <div class="mb-2">
                                                <label class="form-label">{{translate('Title')}}({{strtoupper($lang)}})
                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                    </span></label>
                                            <input type="text"  maxlength="20" name="company_title[]" value="{{ $company_title_translate[$lang]['value']??'' }}" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">{{translate('Sub Title')}}({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_40_characters') }}">
                                                    <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                </span></label>
                                        <input type="text"  maxlength="40" name="company_sub_title[]" value="{{ $company_sub_title_translate[$lang]['value']??'' }}" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">
                                                    {{translate('Short Description')}}({{strtoupper($lang)}})
                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_240_characters') }}">
                                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                                    </span></label>
                                                <textarea maxlength="240" name="company_description[]" class="form-control h--90px">{{ $company_description_translate[$lang]['value']??'' }}</textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                    @endforeach
                                @else
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="form-label">{{translate('Title')}}</label>
                                        <input type="text" name="company_title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">{{translate('Sub Title')}}</label>
                                        <input type="text" name="company_sub_title[]" class="form-control" placeholder="{{translate('messages.sub_title_here...')}}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">
                                            {{translate('Short Description')}}
                                        </label>
                                        <textarea name="company_description[]" class="form-control h--90px"></textarea>
                                    </div>
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title">
                                        <img src="{{asset('public/assets/admin/img/btn-cont.png')}}" class="mr-2" alt="">
                                        {{translate('Button Content')}}
                                    </h5>
                                </div>
                                <div class="__bg-F8F9FC-card">
                                    @if ($language)
                                        <div class="form-group lang_form default-form">
                                            <label class="form-label text-capitalize">
                                                {{translate('Button Name')}}({{ translate('messages.default') }})
                                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text" maxlength="20" name="company_button_name[]" value="{{ $company_button_name?->getRawOriginal('value')??'' }}"  placeholder="{{translate('Ex: Order now')}}" class="form-control h--45px" value="">
                                        </div>
                                    @foreach(json_decode($language) as $lang)
                                    <?php
                                    if(isset($company_button_name->translations)&&count($company_button_name->translations)){
                                            $company_button_name_translate = [];
                                            foreach($company_button_name->translations as $t)
                                            {   
                                                if($t->locale == $lang && $t->key=='company_button_name'){
                                                    $company_button_name_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                    
                                        }
                                        ?>
                                        <div class="form-group d-none lang_form" id="{{$lang}}-form1">
                                            <label class="form-label text-capitalize">
                                                {{translate('Button Name')}}({{strtoupper($lang)}})
                                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text" maxlength="20" name="company_button_name[]" value="{{ $company_button_name_translate[$lang]['value']??'' }}"  placeholder="{{translate('Ex: Order now')}}" class="form-control h--45px" value="">
                                        </div>
                                    @endforeach
                                @else
                                <div class="form-group">
                                    <label class="form-label text-capitalize">
                                        {{translate('Button Name')}}
                                        <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input type="text" placeholder="{{translate('Ex: Order now')}}" class="form-control h--45px" name="company_button_name[]" value="">
                                </div>
                                @endif
                                    <div class="form-group mb-md-0">
                                        <label class="form-label text-capitalize">
                                            {{translate('Redirect Link')}}
                                            <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('The_button_will_direct_users_to_the_link_contained_within_this_box.') }}">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>
                                        <input type="text" placeholder="{{translate('Ex: https://www.apple.com/app-store/')}}" class="form-control h--45px" name="company_button_url" value="{{ $company_button_url['value']??'' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end mt-3">
                    <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                    <button type="submit" onclick="" class="btn btn--primary mb-2">{{translate('Save Information')}}</button>
                </div>
            </form>
        
            
            <div class="modal fade" id="header-section">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3">{{translate('Header Section')}}</h3>
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
