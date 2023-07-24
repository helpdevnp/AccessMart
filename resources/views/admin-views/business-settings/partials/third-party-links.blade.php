<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link   {{ Request::is('admin/business-settings/third-party/payment-method') ? 'active' : '' }}" href="{{ route('admin.business-settings.third-party.payment-method') }}"   aria-disabled="true">{{translate('Payment Methods')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/third-party/sms-module') ? 'active' : '' }}" href="{{ route('admin.business-settings.third-party.sms-module') }}"  aria-disabled="true">{{translate('SMS Module')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/third-party/mail-config') || Request::is('admin/business-settings/third-party/test-mail')  ? 'active' : '' }}" href="{{ route('admin.business-settings.third-party.mail-config') }}"  aria-disabled="true">{{translate('Mail Config')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/third-party/config-setup') ?'active':'' }}" href="{{ route('admin.business-settings.third-party.config-setup') }}"  aria-disabled="true">{{translate('Map APIs')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::is('admin/business-settings/third-party/social-login/view')?'active':''}}" href="{{route('admin.business-settings.third-party.social-login.view')}}"  aria-disabled="true">{{translate('Social Logins')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/third-party/recaptcha*') ? 'active' : '' }}" href="{{route('admin.business-settings.third-party.recaptcha_index')}}"  aria-disabled="true">{{translate('Recaptcha')}}</a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>