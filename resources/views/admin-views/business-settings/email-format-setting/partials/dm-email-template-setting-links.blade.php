<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/dm/registration') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['dm','registration']) }}">
                {{translate('New_Deliveryman_Registration')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/dm/approve') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['dm','approve']) }}">
                {{translate('New_Deliveryman_Approval')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/dm/deny') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['dm','deny']) }}">
                {{translate('New_Deliveryman_Rejection')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/dm/suspend') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['dm','suspend']) }}">
                    {{translate('Account_Suspension')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/dm/cash-collect') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['dm','cash-collect']) }}">
                    {{translate('Cash_Collection')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/dm/forgot-password') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['dm','forgot-password']) }}">
                    {{translate('Forgot_Password')}}
                </a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>