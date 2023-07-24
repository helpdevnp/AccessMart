<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/admin/forgot-password') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['admin','forgot-password']) }}">
                    {{translate('Forgot Password')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/admin/store-registration') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['admin','store-registration']) }}">
                    {{translate('New Store Registration')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/admin/dm-registration') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['admin','dm-registration']) }}">
                    {{translate('New Delivery Man Registration')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/admin/withdraw-request') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['admin','withdraw-request']) }}">
                    {{translate('Withdraw Request')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/admin/campaign-request') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['admin','campaign-request']) }}">
                    {{translate('Campaign Join Request')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/admin/refund-request') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['admin','refund-request']) }}">
                    {{translate('Refund Request')}}
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/admin/login') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['admin','login']) }}">
                    {{translate('Login mail')}}
                </a>
            </li> --}}
        </ul>
        <!-- End Nav -->
    </div>
</div>