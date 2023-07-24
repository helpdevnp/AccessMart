@extends('layouts.admin.app')

@section('title',translate('messages.flutter_web_landing_page'))

@section('content')

<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/flutter.png')}}" class="w--20" alt="">
                </span>
                <span>
                    {{ translate('messages.flutter_web_landing_page') }}
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
            @include('admin-views.business-settings.landing-page-settings.top-menu-links.flutter-landing-page-links')
        </div>
    </div>
    <ul class="nav nav-tabs mb-4 border-0">
        <li class="nav-item">
            <a class="nav-link lang_link active" data-toggle="tab" href="#en-link">English(EN)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link lang_link" data-toggle="tab" href="#ar-link">Arabic - العربية(AR)</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="fixed_data">
            @include('admin-views.business-settings.landing-page-settings.flutter-fixed-data')
        </div>
        <div class="tab-pane fade show" id="special_criteria">
            @include('admin-views.business-settings.landing-page-settings.flutter-landing-page-special-criteria')
        </div>
        <div class="tab-pane fade show" id="join_as">
            @include('admin-views.business-settings.landing-page-settings.flutter-landing-page-join-as')
        </div>
        <div class="tab-pane fade show" id="download_apps">
            @include('admin-views.business-settings.landing-page-settings.flutter-download-apps')
        </div>
    </div>

    <!-- How it Works -->
    @include('admin-views.business-settings.landing-page-settings.partial.how-it-work')
</div>

@endsection