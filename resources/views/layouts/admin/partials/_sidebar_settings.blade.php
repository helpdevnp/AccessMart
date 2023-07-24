<div id="sidebarMain" class="d-none">
    <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->
                @php($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()->value)
                <a class="navbar-brand" href="{{ route('admin.business-settings.business-setup') }}" aria-label="Front">
                    <img class="navbar-brand-logo initial--36" onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'" src="{{ asset('storage/app/public/business/' . $store_logo) }}" alt="Logo">
                    <img class="navbar-brand-logo-mini initial--36" onerror="this.src='{{ asset('public/assets/admin/img/160x160/img2.jpg') }}'" src="{{ asset('storage/app/public/business/' . $store_logo) }}" alt="Logo">
                </a>
                <!-- End Logo -->

                <!-- Navbar Vertical Toggle -->
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                    <i class="tio-clear tio-lg"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->

                <div class="navbar-nav-wrap-content-left">
                    <!-- Navbar Vertical Toggle -->
                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                        data-placement="right" title="Collapse"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                        data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

            </div>

            <!-- Content -->
            <div class="navbar-vertical-content bg--005555" id="navbar-vertical-content">
                <form class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input type="text" class="form-control form--control" placeholder="{{ translate('Search Menu...') }}" id="search-sidebar-menu">
                    </div>
                </form>
                <ul class="navbar-nav navbar-nav-lg nav-tabs">

                <!-- Business Settings -->
                <li class="nav-item">
                    <small class="nav-subtitle" title="{{ translate('messages.business') }} {{ translate('messages.settings') }}">{{ translate('messages.business') }}
                        {{ translate('messages.management') }}</small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                @if (\App\CentralLogics\Helpers::module_permission_check('zone'))
                <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/zone*') ? 'active' : '' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.business-settings.zone.home') }}" title="{{ translate('messages.zone_setup') }}">
                        <i class="tio-city nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            {{ translate('messages.zone_setup') }} </span>
                    </a>
                </li>
                @endif

                @if (\App\CentralLogics\Helpers::module_permission_check('module'))
                <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/module') ? 'active' : '' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" id="tourb-3" href="javascript:" title="{{ translate('messages.system_module_setup') }}">
                        <i class="tio-globe nav-icon"></i>
                        <span class="text-truncate">{{ translate('messages.module_setup') }}</span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:{{ Request::is('admin/business-settings/module*') ? 'block' : 'none' }}">
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/module/create') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.business-settings.module.create') }}" title="{{ translate('messages.add_Business_Module') }}">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate">
                                    {{ translate('messages.add_Business_Module') }}
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/module') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ route('admin.business-settings.module.index') }}" title="{{ translate('messages.modules') }}">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate">
                                    {{ translate('messages.modules') }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if (\App\CentralLogics\Helpers::module_permission_check('settings'))
                <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/business-setup*') || Request::is('admin/business-settings/language*') ? 'active' : '' }}">
                    <a class="nav-link " href="{{ route('admin.business-settings.business-setup') }}" title="{{ translate('messages.business') }} {{ translate('messages.setup') }}">
                        <span class="tio-settings nav-icon"></span>
                        <span class="text-truncate">{{ translate('messages.business') }}
                            {{ translate('messages.settings') }}</span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/pages*') ? 'active' : '' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="{{ translate('messages.pages') }} {{ translate('messages.setup') }}">
                        <i class="tio-pages nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.pages_&_social_media') }}</span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"  style="display:{{ Request::is('admin/business-settings/pages*') ? 'block' : 'none' }}">

                        <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/pages/social-media')?'active':''}}">
                            <a class="nav-link " href="{{route('admin.business-settings.social-media.index')}}" title="{{translate('messages.Social Media')}}">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate">{{translate('messages.Social Media')}}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/pages/admin-landing-page-settings*') ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('admin.business-settings.admin-landing-page-settings','fixed-data') }}" title="{{ translate('messages.admin_landing_page_settings') }}">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate">{{ translate('messages.admin_landing_page') }}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/pages/react-landing-page-settings*') ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('admin.business-settings.react-landing-page-settings','header') }}" title="{{ translate('messages.react_landing_page') }}">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate">{{ translate('messages.react_landing_page') }}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/pages/flutter-landing-page-settings*') ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('admin.business-settings.flutter-landing-page-settings','fixed-data') }}" title="{{ translate('messages.flutter_landing_page') }}">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate">{{ translate('messages.flutter_landing_page') }}</span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/pages/business-page*') ? 'active' : '' }}">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="{{ translate('messages.business') }} {{ translate('messages.pages') }}">
                                <span class="tio-circle nav-indicator-icon"></span>    
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.business') }} {{ translate('messages.pages') }}</span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"  style="display:{{ Request::is('admin/business-settings/pages/business-page*') ? 'block' : 'none' }}">
                                <li class="nav-item {{ Request::is('admin/business-settings/pages/business-page/terms-and-conditions') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.business-settings.terms-and-conditions') }}" title="{{ translate('messages.terms_and_condition') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ translate('messages.terms_and_condition') }}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ Request::is('admin/business-settings/pages/business-page/privacy-policy') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.business-settings.privacy-policy') }}" title="{{ translate('messages.privacy_policy') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ translate('messages.privacy_policy') }}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ Request::is('admin/business-settings/pages/business-page/about-us') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.business-settings.about-us') }}" title="{{ translate('messages.about_us') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ translate('messages.about_us') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item {{ Request::is('admin/business-settings/pages/business-page/refund') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.business-settings.refund') }}" title="{{ translate('messages.Refund Policy') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ translate('Refund Policy') }}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ Request::is('admin/business-settings/pages/business-page/cancelation') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.business-settings.cancelation') }}" title="{{ translate('messages.Cancelation Policy') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ translate('Cancelation Policy') }}</span>
                                    </a>
                                </li>


                                <li class="nav-item {{ Request::is('admin/business-settings/pages/business-page/shipping-policy') ? 'active' : '' }}">
                                    <a class="nav-link " href="{{ route('admin.business-settings.shipping-policy') }}" title="{{ translate('messages.shipping_policy') }}">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate">{{ translate('Shipping Policy') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/file-manager*') ? 'active' : '' }}">
                    <a class="nav-link " href="{{ route('admin.business-settings.file-manager.index') }}" title="{{ translate('messages.gallery') }}">
                        <span class="tio-album nav-icon"></span>
                        <span class="text-truncate text-capitalize">{{ translate('messages.gallery') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <small class="nav-subtitle" title="{{ translate('messages.business') }} {{ translate('messages.settings') }}">{{ translate('messages.system_management') }}</small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/third-party*') || Request::is('admin/business-settings/fcm*') || Request::is('admin/business-settings/login-url-page*')  ? 'active' : '' }}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="{{ translate('messages.3rd_party_&_configurations') }}">
                        <span class="nav-icon tio-account-square-outlined"></span>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">{{ translate('messages.3rd_party_&_configurations') }}</span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"  style="display:{{ Request::is('admin/business-settings/third-party*')|| Request::is('admin/business-settings/fcm*') ? 'block' : 'none' }}">
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/third-party*') ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('admin.business-settings.third-party.payment-method') }}" title="{{ translate('messages.3rd_party') }}">
                                <span class="tio-circle nav-indicator-icon"></span>    
                                <span class="text-truncate">{{ translate('messages.3rd_party') }}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/fcm*') ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('admin.business-settings.fcm-index') }}" title="{{ translate('messages.firebase_notification') }}">
                                <span class="tio-circle nav-indicator-icon"></span>    
                                <span class="text-truncate">{{ translate('messages.firebase_notification') }}</span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/login-url-page*') ? 'active' : '' }}">
                            <a class="nav-link " href="{{ route('admin.business-settings.login_url_page') }}" title="{{ translate('messages.login_url_page') }}">
                                <span class="tio-circle nav-indicator-icon"></span>    
                                <span class="text-truncate">{{ translate('messages.login_url_page') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/react*') ? 'active' : '' }}">
                    <a class="nav-link " href="{{ route('admin.business-settings.react-setup') }}"
                        title="{{ translate('messages.react_site') }}">
                        <span class="tio-rear-window-defrost nav-icon"></span>
                        <span class="text-truncate">{{ translate('messages.react_site') }}</span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/email-setup*') ? 'active' : '' }}">
                    <a class="nav-link " href="{{ route('admin.business-settings.email-setup',['admin','forgot-password']) }}" title="{{ translate('messages.email_template') }}">
                        <span class="tio-email nav-icon"></span>
                        <span class="text-truncate">{{ translate('messages.email_template') }}</span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu {{ Request::is('admin/business-settings/app-settings*') ? 'active' : '' }}">
                    <a class="nav-link " href="{{ route('admin.business-settings.app-settings') }}" title="{{ translate('messages.app_settings') }}">
                        <span class="tio-android nav-icon"></span>
                        <span class="text-truncate">{{ translate('messages.app_settings') }}</span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu {{Request::is('admin/business-settings/db-index')?'active':''}}">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{route('admin.business-settings.db-index')}}" title="{{translate('messages.clean_database')}}">
                        <i class="tio-cloud nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            {{translate('messages.clean_database')}}
                        </span>
                    </a>
                </li>
                @endif
                <!-- End web & adpp Settings -->

                <li class="nav-item py-5">

                </li>


                <li class="__sidebar-hs-unfold px-2" id="tourb-9">
                    <div class="hs-unfold w-100">
                        <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#accountNavbarDropdown",
                                    "type": "css-animation"
                                }'>
                            <div class="cmn--media right-dropdown-icon d-flex align-items-center">
                                <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img"
                                        onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                        src="{{asset('storage/app/public/admin')}}/{{auth('admin')->user()->image}}"
                                        alt="Image Description">
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <span class="card-title h5">
                                        {{auth('admin')->user()->f_name}}
                                        {{auth('admin')->user()->l_name}}
                                    </span>
                                    <span class="card-text">{{auth('admin')->user()->email}}</span>
                                </div>
                            </div>
                        </a>

                        <div id="accountNavbarDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account min--240">
                            <div class="dropdown-item-text">
                                <div class="media align-items-center">
                                    <div class="avatar avatar-sm avatar-circle mr-2">
                                        <img class="avatar-img"
                                                onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                src="{{asset('storage/app/public/admin')}}/{{auth('admin')->user()->image}}"
                                                alt="Image Description">
                                    </div>
                                    <div class="media-body">
                                        <span class="card-title h5">{{auth('admin')->user()->f_name}}</span>
                                        <span class="card-text">{{auth('admin')->user()->email}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{route('admin.settings')}}">
                                <span class="text-truncate pr-2" title="Settings">{{translate('messages.settings')}}</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="javascript:" onclick="Swal.fire({
                                title: '{{ translate('messages.Do you want to logout?') }}',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonColor: '#FC6A57',
                                cancelButtonColor: '#363636',
                                confirmButtonText: '{{ translate('messages.Yes') }}',
                                cancelButtonText: '{{ translate('messages.cancel') }}',
                                }).then((result) => {
                                if (result.value) {
                                location.href='{{route('logout')}}';
                                } else{
                                Swal.fire({
                                title: '{{ translate('messages.canceled') }}',
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonColor: '#FC6A57',
                                confirmButtonText: '{{ translate('messages.ok') }}',
                                }) 
                                }
                                })">
                                <span class="text-truncate pr-2" title="Sign out">{{translate('messages.sign_out')}}</span>
                            </a>
                        </div>
                    </div>
                </li>
                </ul>
            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>


@push('script_2')
<script>
    $(window).on('load' , function() {
        if($(".navbar-vertical-content li.active").length) {
            $('.navbar-vertical-content').animate({
                scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
            }, 10);
        }
    });

    var $rows = $('#navbar-vertical-content li');
    $('#search-sidebar-menu').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
</script>
@endpush
