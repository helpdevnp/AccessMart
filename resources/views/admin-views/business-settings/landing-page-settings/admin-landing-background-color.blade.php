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
    <div class="card my-2">
        <div class="card-body">
            <form action="{{ route('admin.business-settings.admin-landing-page-settings', 'background-color') }}"
                method="POST">
                @php($backgroundChange = \App\Models\BusinessSetting::where(['key' => 'backgroundChange'])->first())
                @php($backgroundChange = isset($backgroundChange->value) ? json_decode($backgroundChange->value, true) : null)
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <label class="form-label d-block text-center">{{ translate('Primary Color 1') }}</label>
                        <input name="header-bg" type="color" class="form-control form-control-color" value="{{ isset($backgroundChange['primary_1_hex']) ? $backgroundChange['primary_1_hex'] : '#EF7822' }}" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label d-block text-center">{{ translate('Primary Color 2') }}</label>
                        <input name="footer-bg" type="color" class="form-control form-control-color" value="{{ isset($backgroundChange['primary_2_hex']) ? $backgroundChange['primary_2_hex'] :'#333E4F'}}" required>
                    </div>

                </div>
                <div class="form-group text-right mt-3 mb-0">
                    <button type="submit" class="btn btn--primary">{{ translate('messages.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- How it Works -->
    @include('admin-views.business-settings.landing-page-settings.partial.how-it-work')
@endsection
@push('script_2')
@endpush
