@php($background_Change = \App\Models\BusinessSetting::where(['key' => 'backgroundChange'])->first())
@php($background_Change = isset($background_Change->value) ? json_decode($background_Change->value, true) : null)
<!DOCTYPE html>
<?php
    $landing_site_direction = session()->get('landing_site_direction');
    // if (env('APP_MODE') == 'demo') {
    //     $landing_site_direction = session()->get('landing_site_direction');
    // }else{
    //     $landing_site_direction = \App\Models\BusinessSetting::where('key', 'landing_site_direction')->first();
    //     $landing_site_direction = $landing_site_direction->value ?? 'ltr';
    // }

?>
<html dir="{{ $landing_site_direction }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('public/assets/landing/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/landing/css/customize-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/landing/css/odometer.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/landing/css/owl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/landing/css/main.css') }}"/>

    @php($icon = \App\Models\BusinessSetting::where(['key' => 'icon'])->first()->value ?? '')
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/app/public/business/' . $icon ?? asset('public/assets/landing/img/favicon.svg')) }}">
    @stack('css_or_js')
    @php($backgroundChange = \App\Models\BusinessSetting::where(['key' => 'backgroundChange'])->first())
    @php($backgroundChange = isset($backgroundChange) && $backgroundChange->value ? json_decode($backgroundChange->value,true):'')
    @if (isset($backgroundChange['primary_1_hex']) && isset($backgroundChange['primary_2_hex']))
        <style>
            :root {
                --base-1: <?php echo $backgroundChange['primary_1_hex']; ?>;
                --base-rgb: <?php echo $backgroundChange['primary_1_rgb']; ?>;
                --base-2: <?php echo $backgroundChange['primary_2_hex']; ?>;
                --base-rgb-2:<?php echo $backgroundChange['primary_2_rgb']; ?>;
            }
        </style>
    @endif
</head>

<body>
    @php($landing_page_text = \App\Models\BusinessSetting::where(['key' => 'landing_page_text'])->first())
    @php($landing_page_text = isset($landing_page_text->value) ? json_decode($landing_page_text->value, true) : null)
    @php($fixed_link = \App\Models\DataSetting::where(['key'=>'fixed_link','type'=>'admin_landing_page'])->first())
    @php($fixed_link = isset($fixed_link->value)?json_decode($fixed_link->value, true):null)
    <!-- ==== Preloader ==== -->
    <div id="landing-loader"></div>
    <!-- ==== Preloader ==== -->
    <!-- ==== Header Section Starts Here ==== -->
    <header>
        <div class="navbar-bottom">
            <div class="container">
                <div class="navbar-bottom-wrapper">
                    @php($fav = \App\Models\BusinessSetting::where(['key' => 'icon'])->first()->value ?? '')
                    @php($logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()->value ?? '')
                    <a href="{{route('home')}}" class="logo">
                        <img
                        onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'"
                    src="{{ asset('storage/app/public/business/' . $fav) }}" alt="">
                    </a>
                    <ul class="menu">
                        <li>
                            <a href="{{route('home')}}" class="{{ Request::is('/') ? 'active' : '' }}"><span>{{ translate('messages.home') }}</span></a>
                        </li>
                        <li>
                            <a href="{{route('about-us')}}" class="{{ Request::is('about-us') ? 'active' : '' }}"><span>{{ translate('messages.about_us') }}</span></a>
                        </li>
                        <li>
                            <a href="{{route('privacy-policy')}}" class="{{ Request::is('privacy-policy') ? 'active' : '' }}"><span>{{ translate('messages.privacy_policy') }}</span></a>
                        </li>
                        <li>
                            <a href="{{route('terms-and-conditions')}}" class="{{ Request::is('terms-and-conditions') ? 'active' : '' }}"><span>{{ translate('messages.terms_and_condition') }}</span></a>
                        </li>
                        <li>
                            <a href="{{route('contact-us')}}"  class="{{ Request::is('contact-us') ? 'active' : '' }}"><span>{{ translate('messages.contact_us') }}</span></a>
                        </li>
                        @if ($fixed_link &&$fixed_link['web_app_url_status'])
                                <div class="mt-2">
                                    <a class="cmn--btn me-xl-auto py-2"
                                    href="{{ $fixed_link['web_app_url'] }}" target="_blank">{{ translate('messages.browse_web') }}</a>
                                </div>
                        @endif
                    </ul>
                    <div class="nav-toggle d-lg-none ms-auto me-3">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    @php( $local = session()->has('landing_local')?session('landing_local'):'en')
                    @php($lang = \App\Models\BusinessSetting::where('key', 'system_language')->first())
                    @if ($lang)  
                        <div class="dropdown--btn-hover position-relative">
                            <a class="dropdown--btn border-0 px-3 header--btn text-capitalize d-flex" href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20">
                                    <path d="M16.555 5.412a8.028 8.028 0 00-3.503-2.81 14.899 14.899 0 011.663 4.472 8.547 8.547 0 001.84-1.662zM13.326 7.825a13.43 13.43 0 00-2.413-5.773 8.087 8.087 0 00-1.826 0 13.43 13.43 0 00-2.413 5.773A8.473 8.473 0 0010 8.5c1.18 0 2.304-.24 3.326-.675zM6.514 9.376A9.98 9.98 0 0010 10c1.226 0 2.4-.22 3.486-.624a13.54 13.54 0 01-.351 3.759A13.54 13.54 0 0110 13.5c-1.079 0-2.128-.127-3.134-.366a13.538 13.538 0 01-.352-3.758zM5.285 7.074a14.9 14.9 0 011.663-4.471 8.028 8.028 0 00-3.503 2.81c.529.638 1.149 1.199 1.84 1.66zM17.334 6.798a7.973 7.973 0 01.614 4.115 13.47 13.47 0 01-3.178 1.72 15.093 15.093 0 00.174-3.939 10.043 10.043 0 002.39-1.896zM2.666 6.798a10.042 10.042 0 002.39 1.896 15.196 15.196 0 00.174 3.94 13.472 13.472 0 01-3.178-1.72 7.973 7.973 0 01.615-4.115zM10 15c.898 0 1.778-.079 2.633-.23a13.473 13.473 0 01-1.72 3.178 8.099 8.099 0 01-1.826 0 13.47 13.47 0 01-1.72-3.178c.855.151 1.735.23 2.633.23zM14.357 14.357a14.912 14.912 0 01-1.305 3.04 8.027 8.027 0 004.345-4.345c-.953.542-1.971.981-3.04 1.305zM6.948 17.397a8.027 8.027 0 01-4.345-4.345c.953.542 1.971.981 3.04 1.305a14.912 14.912 0 001.305 3.04z" />
                                </svg>
                                @foreach(json_decode($lang['value'],true) as $data)
                                @if($data['code']==$local)
                                            <span class="me-1">{{$data['code']}}</span>
                                        @endif
                                    @endforeach
                            </a>
                            <ul class="dropdown-list py-0" style="min-width:120px; top:100%">
                                @foreach(json_decode($lang['value'],true) as $key =>$data)
                                @if($data['status']==1)
                                    <li class="py-0">
                                        <a class="" href="{{route('lang',[$data['code']])}}">
                                            {{$data['code']}}
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider my-0">
                                    </li>
                                @endif
                            @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($toggle_dm_registration || $toggle_store_registration)
                    <div class="dropdown--btn-hover position-relative">
                        <a class="dropdown--btn header--btn text-capitalize d-flex align-items-center" href="javascript:void(0)">
                            <span class="me-1">{{ translate('Join us') }}</span>
                            <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.00224 5.46105L1.33333 0.415128C1.21002 0.290383 1 0.0787335 1 0.0787335C1 0.0787335 0.708488 -0.0458817 0.584976 0.0788632L0.191805 0.475841C0.0680976 0.600389 7.43292e-08 0.766881 7.22135e-08 0.9443C7.00978e-08 1.12172 0.0680976 1.28801 0.191805 1.41266L5.53678 6.80682C5.66068 6.93196 5.82624 7.00049 6.00224 7C6.17902 7.00049 6.34439 6.93206 6.46839 6.80682L11.8082 1.41768C11.9319 1.29303 12 1.12674 12 0.949223C12 0.771804 11.9319 0.605509 11.8082 0.480765L11.415 0.0838844C11.1591 -0.174368 10.9225 0.222512 10.6667 0.480765L6.00224 5.46105Z"
                                    fill="#000000" />
                            </svg>
                        </a>

                        <ul class="dropdown-list">
                            @if ($toggle_store_registration)
                            <li>
                                <a class="" href="{{ route('restaurant.create') }}">
                                    {{ translate('messages.store_registration') }}
                                </a>
                            </li>
                            @if ($toggle_dm_registration)
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endif
                        @endif
                        @if ($toggle_dm_registration)
                            <li><a class=""
                                    href="{{ route('deliveryman.create') }}">{{ translate('messages.deliveryman_registration') }}</a>
                            </li>
                        @endif
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </header>
    <!-- ==== Header Section Ends Here ==== -->
    @yield('content')
    <!-- ======= Footer Section ======= -->

    <footer>
        @php($fixed_newsletter_title = \App\Models\DataSetting::where(['type' => 'admin_landing_page','key' => 'fixed_newsletter_title'])->first())
        @php($fixed_newsletter_title = isset($fixed_newsletter_title->value) ? $fixed_newsletter_title->value: null)
        @php($fixed_newsletter_sub_title = \App\Models\DataSetting::where(['type' => 'admin_landing_page','key' => 'fixed_newsletter_sub_title'])->first())
        @php($fixed_newsletter_sub_title = isset($fixed_newsletter_sub_title->value) ? $fixed_newsletter_sub_title->value: null)
        @php($fixed_footer_article_title = \App\Models\DataSetting::where(['type' => 'admin_landing_page','key' => 'fixed_footer_article_title'])->first())
        @php($fixed_footer_article_title = isset($fixed_footer_article_title->value) ? $fixed_footer_article_title->value: null)
        <div class="newsletter-section">
            <div class="container">
                <div class="newsletter-wrapper">
                    <div class="newsletter-content position-relative">
                        <h3 class="title">{{ $fixed_newsletter_title }}</h3>
                        <div class="text">
                            {{ $fixed_newsletter_sub_title }}
                        </div>
                        <form method="post" action="{{route('newsletter.subscribe')}}">
                            @csrf
                            <div class="input--grp">
                                <input type="email" name="email" required class="form-control" placeholder="Enter your email address">
                                <button class="search-btn" type="submit">
                                    <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="46" height="46" rx="23" fill="url(#paint0_linear_28_1864)" />
                                        <path
                                            d="M25.9667 22.997L19.3001 29.2222C19.1353 29.3866 18.8556 29.6667 18.8556 29.6667C18.8556 29.6667 18.691 30.0553 18.8558 30.22L19.3803 30.7443C19.5448 30.9092 19.7648 31 19.9992 31C20.2336 31 20.4533 30.9092 20.618 30.7443L27.7448 23.6176C27.9101 23.4524 28.0006 23.2317 28 22.997C28.0006 22.7613 27.9102 22.5408 27.7448 22.3755L20.6246 15.2557C20.46 15.0908 20.2403 15 20.0057 15C19.7713 15 19.5516 15.0908 19.3868 15.2557L18.8624 15.78C18.5212 16.1212 19.0456 16.4367 19.3868 16.7778L25.9667 22.997Z"
                                            fill="white" />
                                        <defs>
                                            <linearGradient id="paint0_linear_28_1864" x1="-2.04694e-07" y1="23.4694"
                                                x2="47.5207" y2="23.4694" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#34DD8E" />
                                                <stop offset="1" stop-color="#00D571" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-wrapper ps-xl-5">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a class="logo">
                                <img onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'"
                            src="{{ asset('storage/app/public/business/' . $logo) }}" alt="">
                            </a>
                        </div>
                        <div class="txt">
                            {{ $fixed_footer_article_title }}
                        </div>
                        <ul class="social-icon">
                            @php($social_media = \App\Models\SocialMedia::where('status', 1)->get())
                            @if (isset($social_media))
                                @foreach ($social_media as $social)
                                <li>
                                    <a href="{{ $social->link }}" target="_blank">
                                        <img src="{{ asset('public/assets/landing/img/footer/'. $social->name.'.svg') }}" alt="">
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                        @php($landing_page_links = \App\Models\DataSetting::where(['type' => 'admin_landing_page','key' => 'download_user_app_links'])->first())
                        @php($landing_page_links = isset($landing_page_links->value) ? json_decode($landing_page_links->value, true) : null)
                        @if (isset($landing_page_links['playstore_url_status']) || isset( $landing_page_links['apple_store_url_status']))
                        <div class="app-btn-grp">
                            @if (isset($landing_page_links['playstore_url_status']))
                            <a href="{{ isset($landing_page_links['playstore_url']) ? $landing_page_links['playstore_url'] : '' }}">
                                <img src="{{ asset('public/assets/landing/img/google.svg') }}" alt="">
                            </a>
                            @endif
                            @if (isset($landing_page_links['apple_store_url_status']))
                            <a href="{{ isset($landing_page_links['apple_store_url']) ? $landing_page_links['apple_store_url'] : '' }}">
                                <img src="{{ asset('public/assets/landing/img/apple.svg') }}" alt="">
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                    @php($landing_data =\App\Models\DataSetting::where('type', 'admin_landing_page')->whereIn('key', ['shipping_policy_status','refund_policy_status','cancellation_policy_status'])->pluck('value','key')->toArray())
                    <div class="footer-widget widget-links">
                        <h5 class="subtitle mt-2 text-white">{{translate("messages.Suppport")}}</h5>
                        <ul>
                            <li>
                                <a href="{{route('privacy-policy')}}">{{ translate('messages.privacy_policy') }}</a>
                            </li>
                            <li>
                                <a href="{{route('terms-and-conditions')}}">{{ translate('messages.terms_and_condition') }}</a>
                            </li>

                            @if (isset($landing_data['refund_policy_status']) && $landing_data['refund_policy_status']  == 1)
                            <li>
                                <a href="{{route('refund')}}">{{ translate('messages.Refund Policy') }}</a>
                            </li>
                            @endif
                            @if (isset($landing_data['shipping_policy_status']) && $landing_data['shipping_policy_status']  == 1)
                            <li>
                                <a href="{{route('shipping-policy')}}">{{ translate('messages.Shipping Policy') }}</a>
                            </li>
                            @endif
                            @if (isset($landing_data['cancellation_policy_status']) && $landing_data['cancellation_policy_status']  == 1)
                            <li>
                                <a href="{{route('cancelation')}}">{{ translate('messages.Cancelation Policy') }}</a>
                            </li>
                            @endif

                        </ul>
                    </div>
                    <div class="footer-widget widget-links">
                        <h5 class="subtitle mt-2 text-white">{{translate("messages.Contact")}} {{translate("messages.Us")}} </h5>
                        <ul>
                            <li>
                                <a>
                                    <svg width="16" height="16" viewBox="0 0 12 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.2379 2.73992C9.26683 1.06417 7.54208 0.0403906 5.62411 0.00126563C5.54223 -0.000421875 5.45983 -0.000421875 5.37792 0.00126563C3.45998 0.0403906 1.73523 1.06417 0.764169 2.73992C-0.228393 4.4528 -0.25555 6.5103 0.691513 8.24376L4.65911 15.5059C4.66089 15.5091 4.66267 15.5123 4.66451 15.5155C4.83908 15.8189 5.15179 16 5.50108 16C5.85033 16 6.16304 15.8189 6.33757 15.5155C6.33942 15.5123 6.3412 15.5091 6.34298 15.5059L10.3106 8.24376C11.2576 6.5103 11.2304 4.4528 10.2379 2.73992ZM5.50101 7.25002C4.26036 7.25002 3.25101 6.24067 3.25101 5.00002C3.25101 3.75936 4.26036 2.75002 5.50101 2.75002C6.74167 2.75002 7.75101 3.75936 7.75101 5.00002C7.75101 6.24067 6.7417 7.25002 5.50101 7.25002Z"
                                            fill="white" />
                                    </svg>
                                    {{ \App\CentralLogics\Helpers::get_settings('address') }}
                                </a>
                            </li>
                            <li>
                                <a href="mailto:{{ \App\CentralLogics\Helpers::get_settings('email_address') }}">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0.333768 2.97362C2.52971 4.83334 6.38289 8.10516 7.51539 9.12531C7.66742 9.263 7.83049 9.333 7.99977 9.333C8.16871 9.333 8.33149 9.26366 8.48317 9.12663C9.61664 8.10547 13.4698 4.83334 15.6658 2.97362C15.8025 2.85806 15.8234 2.65494 15.7127 2.51366C15.4568 2.18719 15.0753 2 14.6664 2H1.33311C0.924268 2 0.542737 2.18719 0.286893 2.51369C0.176205 2.65494 0.197049 2.85806 0.333768 2.97362Z"
                                            fill="white" />
                                        <path
                                            d="M15.8067 3.98127C15.6885 3.92627 15.5495 3.94546 15.4512 4.02946C13.0159 6.0939 9.90788 8.74008 8.93 9.62124C8.38116 10.1167 7.61944 10.1167 7.06931 9.62058C6.027 8.68146 2.53675 5.71433 0.548813 4.02943C0.449844 3.94543 0.310531 3.9269 0.193344 3.98124C0.0755312 4.03596 0 4.1538 0 4.28368V12.6665C0 13.4019 0.597969 13.9998 1.33334 13.9998H14.6667C15.402 13.9998 16 13.4019 16 12.6665V4.28368C16 4.1538 15.9245 4.03565 15.8067 3.98127Z"
                                            fill="white" />
                                    </svg>
                                    {{ \App\CentralLogics\Helpers::get_settings('email_address') }}
                                </a>
                            </li>
                            <li>
                                <a href="tel:{{ \App\CentralLogics\Helpers::get_settings('phone') }}">
                                    <svg width="16" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13.6043 10.2746L11.6505 8.32085C10.9528 7.62308 9.76655 7.90222 9.48744 8.80928C9.27812 9.4373 8.58035 9.78618 7.95236 9.6466C6.55683 9.29772 4.67287 7.48353 4.32398 6.01822C4.11465 5.39021 4.53331 4.69244 5.1613 4.48314C6.0684 4.20403 6.3475 3.01783 5.64974 2.32007L3.696 0.366327C3.13778 -0.122109 2.30047 -0.122109 1.81203 0.366327L0.486277 1.69208C-0.839476 3.08761 0.62583 6.78576 3.90533 10.0653C7.18482 13.3448 10.883 14.8799 12.2785 13.4843L13.6043 12.1586C14.0927 11.6003 14.0927 10.763 13.6043 10.2746Z"
                                            fill="white" />
                                    </svg>
                                    {{ \App\CentralLogics\Helpers::get_settings('phone') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="copyright text-center mt-3">
                    &copy; {{ \App\CentralLogics\Helpers::get_settings('footer_text') }}
                        by {{ \App\CentralLogics\Helpers::get_settings('business_name') }}
                </div>
            </div>
        </div>
    </footer>
    <!-- ======= Footer Section ======= -->
    <script src="{{ asset('public/assets/landing/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('public/assets/landing/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/assets/landing/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('public/assets/landing/js/wow.min.js') }}"></script>
    <script src="{{ asset('public/assets/landing/js/odometer.min.js') }}"></script>
    <script src="{{ asset('public/assets/landing/js/owl.min.js') }}"></script>
    <script src="{{ asset('public/assets/landing/js/main.js') }}"></script>
    <script src="{{ asset('public/assets/admin') }}/js/toastr.js"></script>
    {!! Toastr::message() !!}
    @if ($errors->any())
        <script>
            @foreach($errors->all() as $error)
            toastr.error('{{$error}}', Error, {
                CloseButton: true,
                ProgressBar: true
            });
            @endforeach
        </script>
    @endif


    @stack('script_2')


    <script>

        $(".main-category-slider").owlCarousel({
            loop: true,
            nav: false,
            dots: true,
            items: 1,
            margin: 12,
            autoplay: true,
            rtl: {{ $landing_site_direction === 'rtl'?'true':'false' }},
        });
        $(".testimonial-slider").owlCarousel({
            loop: false,
            margin: 22,
            responsiveClass: true,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            items: 1,
            rtl: {{ $landing_site_direction === 'rtl'?'true':'false' }},
            responsive: {
                768: {
                    items: 2,
                },
                992: {
                    items: 3,
                },
                1200: {
                    items: 3,
                },
            },
        });
        $(".owl-prev").html('<i class="fas fa-angle-left">');
        $(".owl-next").html('<i class="fas fa-angle-right">');
        var sync1 = $("#sync1");
        var sync2 = $("#sync2");
        var thumbnailItemClass = ".owl-item";
        var slides = sync1
            .owlCarousel({
                startPosition: 12,
                items: 1,
                loop: false,
                margin: 0,
                mouseDrag: true,
                touchDrag: true,
                pullDrag: false,
                scrollPerPage: true,
                autoplayHoverPause: false,
                nav: false,
                dots: false,
                // center: true,
                rtl: {{ $landing_site_direction === 'rtl'?'true':'false' }},
            })
            .on("changed.owl.carousel", syncPosition);

        function syncPosition(el) {
            $owl_slider = $(this).data("owl.carousel");
            var loop = $owl_slider.options.loop;

            if (loop) {
                var count = el.item.count - 1;
                var current = Math.round(
                    el.item.index - el.item.count / 2 - 0.5
                );
                if (current < 0) {
                    current = count;
                }
                if (current > count) {
                    current = 0;
                }
            } else {
                var current = el.item.index;
            }

            var owl_thumbnail = sync2.data("owl.carousel");
            var itemClass = "." + owl_thumbnail.options.itemClass;

            var thumbnailCurrentItem = sync2
                .find(itemClass)
                .removeClass("synced")
                .eq(current);
            thumbnailCurrentItem.addClass("synced");

            if (!thumbnailCurrentItem.hasClass("active")) {
                var duration = 500;
                sync2.trigger("to.owl.carousel", [current, duration, true]);
            }
        }
        var thumbs = sync2
            .owlCarousel({
                startPosition: 12,
                items: 2,
                loop: false,
                margin: 10,
                autoplay: false,
                nav: false,
                dots: false,
                // center: true,
                mouseDrag: true,
                touchDrag: true,
                rtl: {{ $landing_site_direction === 'rtl'?'true':'false' }},
                responsive: {
                    400: {
                        items: 3,
                    },
                    768: {
                        items: 5,
                    },
                    1200: {
                        items: 6,
                    },
                },
                onInitialized: function (e) {
                    var thumbnailCurrentItem = $(e.target)
                        .find(thumbnailItemClass)
                        .eq(this._current);
                    thumbnailCurrentItem.addClass("synced");
                },
            })
            .on("click", thumbnailItemClass, function (e) {
                e.preventDefault();
                var duration = 500;
                var itemIndex = $(e.target).parents(thumbnailItemClass).index();
                sync1.trigger("to.owl.carousel", [itemIndex, duration, true]);
            })
            .on("changed.owl.carousel", function (el) {
                var number = el.item.index;
                $owl_slider = sync1.data("owl.carousel");
                $owl_slider.to(number, 500, true);
            });
        sync1.owlCarousel();

    </script>


</body>

</html>
