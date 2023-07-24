<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/flutter-landing-page-settings/fixed-data') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.flutter-landing-page-settings', 'fixed-data') }}">{{translate('messages.fixed_data')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/flutter-landing-page-settings/special-criteria*') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.flutter-landing-page-settings', 'special-criteria') }}">{{translate('messages.special_criteria')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/flutter-landing-page-settings/join-as') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.flutter-landing-page-settings', 'join-as') }}">{{translate('messages.join_as')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/flutter-landing-page-settings/download-apps') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.flutter-landing-page-settings', 'download-apps') }}">{{translate('messages.download_apps')}}</a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>