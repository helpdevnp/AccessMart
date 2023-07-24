@extends('layouts.admin.app')

@section('title', translate('messages.landing_page_settings'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/admin/css/croppie.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <!-- Page Header -->
            <h1 class="page-header-title text-capitalize">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/landing.png')}}" class="w--26" alt="">
                </span>
                <span>
                    {{ translate('messages.landing_page_settings') }}
                </span>
            </h1>
            <!-- End Page Header -->
            <!-- Nav Scroller -->
            <div class="mb-5">
                <div class="js-nav-scroller hs-nav-scroller-horizontal">
                    <!-- Nav -->
                    @include('admin-views.business-settings.landing-page-settings.top-menu-links.top-menu-links')
                    <!-- End Nav -->
                </div>
            </div>
            <!-- End Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal mb-5">
                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active"
                            href="{{ route('admin.business-settings.landing-page-settings', 'react') }}"
                            aria-disabled="true">{{ translate('React Landing Page') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "
                            href="{{ route('admin.business-settings.landing-page-settings', 'react-feature') }}"
                            aria-disabled="true">{{ translate('React Landing Page Features') }}</a>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Page Heading -->

        <div class="card my-2">
            <div class="card-body">
                @php($react_header_banner = \App\Models\BusinessSetting::where(['key' => 'react_header_banner'])->first())
                @php($react_header_banner = isset($react_header_banner->value) ? $react_header_banner->value : null)
                <div class="row gy-3">
                    <div class="col-sm-6 col-xl-4">
                        <form action="{{ route('admin.business-settings.landing-page-settings', 'react_header') }}"
                            method="POST" enctype="multipart/form-data" class="d-flex flex-column h-100">
                            @csrf
                            <div class="form-group">
                                <span
                                    class="input-label text-center mb-3 d-block">{{ translate('Header Section Banner') }}<small
                                        class="text-danger">*
                                        {{-- ( {{translate('messages.size')}}: 1241 X 1755 px ) --}}
                                    </small></span>
                                <label class="d-block">
                                    <div class="custom-file d-none">
                                        <input type="file" name="react_header_banner" id="customFileEg3"
                                            class="custom-file-input" required
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    </div>

                                    <center id="image-viewer-section3">
                                        <img class="initial-7 img--200" id="viewer3"
                                            src="{{ asset('storage/app/public/react_landing/') }}/{{ isset($react_header_banner) ? $react_header_banner : 'react_header_banner.png' }}"
                                            onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'"
                                            alt="" />
                                    </center>
                                </label>
                            </div>
                            <div class="form-group text-center mb-0 mt-auto">
                                <div class="landing--page-btns btn--container justify-content-center">
                                    <label class="btn btn--reset"
                                        for="customFileEg3">{{ translate('Change Image') }}</label>
                                    <button type="submit"
                                        class="btn btn--primary">{{ translate('messages.upload') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        @php($app_section_image = \App\Models\BusinessSetting::where(['key' => 'app_section_image'])->first())
                        @php($app_section_image = isset($app_section_image->value) ? $app_section_image->value : null)
                        <form action="{{ route('admin.business-settings.landing-page-settings', 'app_section_image') }}"
                            method="POST" enctype="multipart/form-data" class="d-flex flex-column h-100">
                            @csrf
                            <div class="form-group">
                                <span
                                    class="input-label text-center mb-3 d-block">{{ translate('App Section Image') }}<small
                                        class="text-danger">*
                                        {{-- ( {{translate('messages.size')}}: 1241 X 1755 px ) --}}
                                    </small></span>
                                <label class="d-block">
                                    <div class="custom-file d-none">
                                        <input type="file" name="app_section_image" id="customFileEg6"
                                            class="custom-file-input" required
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    </div>

                                    <center id="image-viewer-section6">
                                        <img class="initial-7 img--200" id="viewer6"
                                            src="{{ asset('storage/app/public/react_landing') }}/{{ isset($app_section_image) ? $app_section_image : 'app_section_image.png' }}"
                                            onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'"
                                            alt="" />
                                    </center>
                                </label>
                            </div>
                            <div class="form-group text-center mb-0 mt-auto">
                                <div class="landing--page-btns btn--container justify-content-center">
                                    <label class="btn btn--reset"
                                        for="customFileEg6">{{ translate('Change Image') }}</label>
                                    <button type="submit"
                                        class="btn btn--primary">{{ translate('messages.upload') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6 col-xl-4">
                        @php($footer_logo = \App\Models\BusinessSetting::where(['key' => 'footer_logo'])->first())
                        @php($footer_logo = isset($footer_logo->value) ? $footer_logo->value : null)
                        <form action="{{ route('admin.business-settings.landing-page-settings', 'footer_logo') }}"
                            method="POST" enctype="multipart/form-data" class="d-flex flex-column h-100">
                            @csrf
                            <div class="form-group">
                                <span
                                    class="input-label text-center mb-3 d-block">{{ translate('Footer Logo') }}<small
                                        class="text-danger">*
                                        {{-- ( {{translate('messages.size')}}: 1241 X 1755 px ) --}}
                                    </small></span>
                                <label class="d-block">
                                    <div class="custom-file d-none">
                                        <input type="file" name="footer_logo" id="customFileEg7"
                                            class="custom-file-input" required
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    </div>

                                    <center id="image-viewer-section7">
                                        <img class="initial-7 img--200" id="viewer7"
                                            src="{{ asset('storage/app/public/react_landing') }}/{{ isset($footer_logo) ? $footer_logo : 'footer_logo.png' }}"
                                            onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'"
                                            alt="" />
                                    </center>
                                </label>
                            </div>
                            <div class="form-group text-center mb-0 mt-auto">
                                <div class="landing--page-btns btn--container justify-content-center">
                                    <label class="btn btn--reset"
                                        for="customFileEg7">{{ translate('Change Image') }}</label>
                                    <button type="submit"
                                        class="btn btn--primary">{{ translate('messages.upload') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>

        <div class="card my-2">
            <div class="card-body">
                <div>
                    <h1 class="text-center">{{ translate('Hero Section') }}</h3>
                </div>
                <div class="card my-2 mt-5">
                    <div class="card-body">
                        <form action="{{ route('admin.business-settings.landing-page-settings', 'hero-section') }}"
                            method="POST" enctype="multipart/form-data">
                            @php($hero_section = \App\Models\BusinessSetting::where(['key' => 'hero_section'])->first())
                            @php($hero_section = isset($hero_section->value) ? json_decode($hero_section->value, true) : null)
                            @csrf

                            <div class="row gy-3">
                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label class="input-label"
                                            for="hero_section_heading">{{ translate('heading') }}</label>
                                        <input type="text" id="hero_section_heading" name="hero_section_heading"
                                            value="{{ $hero_section['hero_section_heading'] ?? null }}" required
                                            class="form-control h--45px" placeholder="{{ translate('Ex: Heading') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="hero_section_slogan">{{ translate('slogan') }}</label>
                                        <input type="text" id="hero_section_slogan" name="hero_section_slogan"
                                            value="{{ $hero_section['hero_section_slogan'] ?? null }}"
                                            class="form-control h--45px" required
                                            placeholder="{{ translate('Ex: Slogan') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="hero_section_short_description">{{ translate('Short Description') }}</label>
                                        <input type="text" id="hero_section_short_description" name="hero_section_short_description"
                                            value="{{ $hero_section['hero_section_short_description'] ?? null }}"
                                            class="form-control h--45px" required
                                            placeholder="{{ translate('Ex: Short Description') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="btn--container justify-content-end">
                                    <button type="reset" id="reset_btn"
                                        class="btn btn--reset">{{ translate('messages.reset') }}</button>
                                    <button type="submit"
                                        class="btn btn--primary">{{ translate('messages.submit') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="card my-2">
            <div class="card-body">
                <div>
                    <h1 class="text-center">{{ translate('Delivery Service Section') }}</h3>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <form action="{{ route('admin.business-settings.landing-page-settings', 'delivery-service-section') }}"
                            method="POST" enctype="multipart/form-data">
                            @php($delivery_service_section = \App\Models\BusinessSetting::where(['key' => 'delivery_service_section'])->first())
                            @php($delivery_service_section = isset($delivery_service_section->value) ? json_decode($delivery_service_section->value, true) : null)
                            @csrf

                            <div class="row gy-3">
                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label class="input-label"
                                            for="delivery_service_section">{{ translate('Title') }}</label>
                                        <input type="text" id="delivery_service_section" name="delivery_service_section_title"
                                            value="{{ $delivery_service_section['delivery_service_section_title'] ?? null }}" required
                                            class="form-control h--45px" placeholder="{{ translate('Ex: Service title') }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="delivery_service_section_description">{{ translate('Description') }}</label>
                                        <input type="text" id="delivery_service_section_description" name="delivery_service_section_description"
                                            value="{{ $delivery_service_section['delivery_service_section_description'] ?? null }}"
                                            class="form-control h--45px" required
                                            placeholder="{{ translate('Ex: Description') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group h-100 d-flex flex-column mb-0">
                                        <label
                                            class="input-label text-center d-block mt-auto mb-lg-0">{{ translate('Image') }}<small
                                                class="text-danger">* (
                                                {{ translate('messages.size') }}: {{ translate('1352 X 250 px') }}
                                                )</small></label>

                                                <center id="image-viewer-section" class="pt-2 mt-auto mb-auto">
                                                    <img class="initial-5 img--200" id="viewer"
                                                        src="{{ asset('storage/app/public/react_landing') }}/{{ $delivery_service_section['delivery_service_section_image'] ?? null }}"
                                                        onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'"
                                                        alt="" />
                                                </center>

                                            <div class="custom-file mt-2">
                                                <input type="file" name="delivery_service_section_image" id="customFileEg1"
                                                    class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" >
                                                <label class="custom-file-label"
                                                    for="customFileEg1">{{ translate('messages.choose') }}
                                                    {{ translate('messages.file') }}</label>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="btn--container justify-content-end">
                                    <button type="reset" id="reset_btn"
                                        class="btn btn--reset">{{ translate('messages.reset') }}</button>
                                    <button type="submit"
                                        class="btn btn--primary">{{ translate('messages.submit') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="card my-2">
            <div class="card-body">
                <div>
                    <h1 class="text-center">{{ translate('React Landing Page Main Banner Image') }}</h3>
                </div>
                <div>
                    <h3>{{ translate('Main Banner') }}</h3>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <form action="{{ route('admin.business-settings.landing-page-settings', 'full-banner') }}"
                            method="POST" enctype="multipart/form-data">
                            @php($full_banner_section = \App\Models\BusinessSetting::where(['key' => 'banner_section_full'])->first())
                            @php($full_banner_section = isset($full_banner_section->value) ? json_decode($full_banner_section->value, true) : null)
                            @csrf

                            <div class="row gy-3">
                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label class="input-label"
                                            for="full_banner_section">{{ translate('Banner Title') }}</label>
                                        <input type="text" id="full_banner_section" name="full_banner_section_title"
                                            value="{{ $full_banner_section['full_banner_section_title'] ?? null }}" required
                                            class="form-control h--45px" placeholder="{{ translate('Ex: Banner title') }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="full_banner_section">{{ translate('Banner Sub Title') }}</label>
                                        <input type="text" id="full_banner_section" name="full_banner_section_sub_title"
                                            value="{{ $full_banner_section['full_banner_section_sub_title'] ?? null }}"
                                            class="form-control h--45px" required
                                            placeholder="{{ translate('Ex: Banner sub title') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group h-100 d-flex flex-column mb-0">
                                        <label
                                            class="input-label text-center d-block mt-auto mb-lg-0">{{ translate('Full Banner Image') }}<small
                                                class="text-danger">* (
                                                {{ translate('messages.size') }}: {{ translate('1352 X 250 px') }}
                                                )</small></label>

                                                <center id="image-viewer-section" class="pt-2 mt-auto mb-auto">
                                                    <img class="initial-5 img--200" id="viewer"
                                                        src="{{ asset('storage/app/public/react_landing') }}/{{ $full_banner_section['banner_section_img_full'] ?? null }}"
                                                        onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'"
                                                        alt="" />
                                                </center>

                                            <div class="custom-file mt-2">
                                                <input type="file" name="banner_section_img_full" id="customFileEg1"
                                                    class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" >
                                                <label class="custom-file-label"
                                                    for="customFileEg1">{{ translate('messages.choose') }}
                                                    {{ translate('messages.file') }}</label>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="btn--container justify-content-end">
                                    <button type="reset" id="reset_btn"
                                        class="btn btn--reset">{{ translate('messages.reset') }}</button>
                                    <button type="submit"
                                        class="btn btn--primary">{{ translate('messages.submit') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="card my-2">
            <div class="card-body">
                <div>
                    <h1 class="text-center">{{ translate('React Landing Page Discount Banner Image') }}</h3>
                </div>
                <div>
                    <h3>{{ translate('Discount Banner') }}</h3>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <form action="{{ route('admin.business-settings.landing-page-settings', 'discount-banner') }}"
                            method="POST" enctype="multipart/form-data">
                            @php($discount_section = \App\Models\BusinessSetting::where(['key' => 'discount_banner'])->first())
                            @php($discount_section = isset($discount_section->value) ? json_decode($discount_section->value, true) : null)
                            @csrf

                            <div class="row gy-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="full_banner_section">{{ translate('Discount Banner Title') }}</label>
                                        <input type="text" id="full_banner_section" name="title"
                                            value="{{ $discount_section['title'] ?? null }}" required
                                            class="form-control h--45px" placeholder="{{ translate('Ex: Discount banner title') }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="full_banner_section">{{ translate('Discount Banner Sub Title') }}</label>
                                        <input type="text" id="full_banner_section" name="sub_title"
                                            value="{{ $discount_section['sub_title'] ?? null }}"
                                            class="form-control h--45px" required
                                            placeholder="{{ translate('Ex: Discount banner sub title') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group h-100 d-flex flex-column mb-0">
                                        <label
                                            class="input-label text-center d-block mt-auto mb-lg-0">{{ translate('Discount Banner Image') }}<small
                                                class="text-danger">* (
                                                {{ translate('messages.size') }}: {{ translate('1352 X 250 px') }}
                                                )</small></label>

                                                <center id="image-viewer-section2" class="pt-2 mt-auto mb-auto">
                                                    <img class="initial-5 img--200" id="viewer2"
                                                        src="{{ asset('storage/app/public/react_landing') }}/{{ $discount_section['img'] ?? null }}"
                                                        onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'"
                                                        alt="" />
                                                </center>

                                            <div class="custom-file mt-2">
                                                <input type="file" name="img" id="customFileEg2"
                                                    class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" >
                                                <label class="custom-file-label"
                                                    for="customFileEg2">{{ translate('messages.choose') }}
                                                    {{ translate('messages.file') }}</label>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="btn--container justify-content-end">
                                    <button type="reset" id="reset_btn"
                                        class="btn btn--reset">{{ translate('messages.reset') }}</button>
                                    <button type="submit"
                                        class="btn btn--primary">{{ translate('messages.submit') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="card my-2">
            <div class="card-body">
                <div>
                    <h1 class="text-center">{{ translate('Half Banner Images') }}</h3>
                </div>
                <div>
                    <h3>{{ translate('Banner') }}</h3>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <form action="{{ route('admin.business-settings.landing-page-settings', 'banner-section-half') }}"
                            method="POST" enctype="multipart/form-data">
                            @php($banner_section_half = \App\Models\BusinessSetting::where(['key' => 'banner_section_half'])->first())
                            @php($banner_section_half = isset($banner_section_half->value) ? json_decode($banner_section_half->value, true) : null)
                            @csrf
                            @for ($i = 0; $i < 2; $i++)
                                <div class="row gy-3">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="banner_section_half">{{ translate('Banner Title') }}</label>
                                            <input type="text" id="banner_section_half" name="banner_section_half[{{ $i }}][title]" required
                                                value="{{ isset($banner_section_half[$i]['title'] ) ? $banner_section_half[$i]['title'] :null }}"
                                                class="form-control h--45px"
                                                placeholder="{{ translate('Ex: Banner title') }}">
                                        </div>
                                        <div class="form-group mb-0">
                                            <label class="input-label"
                                                for="banner_section_half">{{ translate('Banner Sub Title') }}</label>
                                            <input type="text" id="banner_section_half_{{ $i }}"
                                                name="banner_section_half[{{ $i }}][sub_title]"
                                                value="{{  isset($banner_section_half[$i]['sub_title'] ) ? $banner_section_half[$i]['sub_title'] :null }}"
                                                class="form-control h--45px" required
                                                placeholder="{{ translate('Ex: Banner sub title') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group h-100 d-flex flex-column mb-0">
                                            <label
                                                class="input-label text-center d-block mt-auto mb-lg-0">{{ translate('Banner Image') }}<small
                                                    class="text-danger">* (
                                                    {{ translate('messages.size') }}: {{ translate('668 X 250 px') }}
                                                    )</small></label>
                                                <center id="image-viewer-viewer_banner_half_{{ $i }}" class="pt-2 mt-auto mb-auto">
                                                <img class="initial-5 img--200" id="viewer_banner_half_{{ $i }}"
                                                    src="{{ asset('storage/app/public/react_landing') }}/{{ isset($banner_section_half[$i]['img']) ? $banner_section_half[$i]['img'] : 'banner_1.png' }}"
                                                    onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'"
                                                    alt="" />
                                                </center>
                                                <div class="custom-file mt-2">
                                                    <input type="file" name="banner_section_half[{{ $i }}][img]" id="customFile_Eg1_{{ $i }}"
                                                        class="custom-file-input"
                                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                    <label class="custom-file-label"
                                                        for="customFile_Eg1_{{ $i }}">{{ translate('messages.choose') }}
                                                        {{ translate('messages.file') }}</label>
                                                </div>
                                        </div>
                                    </div>
                                </div>

                            @endfor

                            <div class="form-group mt-3">
                                <div class="btn--container justify-content-end">
                                    <button type="reset" id="reset_btn"
                                        class="btn btn--reset">{{ translate('messages.reset') }}</button>
                                    <button type="submit"
                                        class="btn btn--primary">{{ translate('messages.submit') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('script_2')
    <script>
        function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + viewer).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this, 'viewer');
            $('#image-viewer-section').show(1000);
        });
        $("#customFileEg2").change(function() {
            readURL(this, 'viewer2');
            $('#image-viewer-section3').show(1000);
        });
        $("#customFileEg3").change(function() {
            readURL(this, 'viewer3');
            $('#image-viewer-section3').show(1000);
        });
        $("#customFileEg6").change(function() {
            readURL(this, 'viewer6');
            $('#image-viewer-section6').show(1000);
        });
        $("#customFileEg7").change(function() {
            readURL(this, 'viewer7');
            $('#image-viewer-section7').show(1000);
        });
        $("#customFile_Eg1_0").change(function() {
            readURL(this, 'viewer_banner_half_0');
            $('#image-viewer-viewer_banner_half_0').show(1000);
        });
        $("#customFile_Eg1_1").change(function() {
            readURL(this, 'viewer_banner_half_1');
            $('#image-viewer-viewer_banner_half_1').show(1000);
        });

    </script>
@endpush
