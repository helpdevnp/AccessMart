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
    
    <ul class="nav nav-tabs mb-4 border-0">
        <li class="nav-item">
            <a class="nav-link lang_link active" data-toggle="tab" href="#en-link">English(EN)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link lang_link" data-toggle="tab" href="#ar-link">Arabic - العربية(AR)</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="react-header">
            @include('admin-views.business-settings.landing-page-settings.react-landing-page-header')
        </div>
        <div class="tab-pane fade show" id="company_intro">
            @include('admin-views.business-settings.landing-page-settings.react-landing-page-company')
        </div>
        <div class="tab-pane fade show" id="download_user_app">
            @include('admin-views.business-settings.landing-page-settings.react-landing-download-apps')
        </div>
        <div class="tab-pane fade show" id="earn_money">
            @include('admin-views.business-settings.landing-page-settings.react-landing-earn-money')
        </div>
        <div class="tab-pane fade show" id="business_section">
            @include('admin-views.business-settings.landing-page-settings.react-landing-business')
        </div>
        <div class="tab-pane fade show" id="testimonials">
            @include('admin-views.business-settings.landing-page-settings.react-landing-testimonial')
        </div>
    </div>
</div>
<!-- How it Works -->
@include('admin-views.business-settings.landing-page-settings.partial.how-it-work-react')
@endsection
