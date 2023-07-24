<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/react-landing-page-settings/header') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.react-landing-page-settings', 'header') }}">{{translate('Header')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/react-landing-page-settings/company-intro') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.react-landing-page-settings', 'company-intro') }}">{{translate('Company Intro')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/react-landing-page-settings/download-user-app') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.react-landing-page-settings', 'download-user-app') }}">{{translate('Download User App')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/react-landing-page-settings/earn-money') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.react-landing-page-settings', 'earn-money') }}">{{translate('messages.earn_money')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/react-landing-page-settings/promotion-banner') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.react-landing-page-settings', 'promotion-banner') }}">{{translate('Promotional Banners')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/react-landing-page-settings/business-section') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.react-landing-page-settings', 'business-section') }}">{{translate('Business Section')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/react-landing-page-settings/testimonials*') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.react-landing-page-settings', 'testimonials') }}">{{translate('messages.testimonials')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/pages/react-landing-page-settings/fixed-data*') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.react-landing-page-settings', 'fixed-data') }}">{{translate('messages.fixed_Data')}}</a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>