<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/store/registration') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['store','registration']) }}">
                    {{translate('New Store Registration')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/store/approve') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['store','approve']) }}">
                    {{translate('New_Store_Approval')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/store/deny') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['store','deny']) }}">
                    {{translate('New_Store_Rejection')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/store/withdraw-approve') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['store','withdraw-approve']) }}">
                    {{translate('Withdraw_Approval')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/store/withdraw-deny') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['store','withdraw-deny']) }}">
                    {{translate('Withdraw_Rejection')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/store/campaign-request') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['store','campaign-request']) }}">
                    {{translate('Campaign Join Request')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/store/campaign-approve') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['store','campaign-approve']) }}">
                    {{translate('Campaign_Join_Approval')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/email-setup/store/campaign-deny') ? 'active' : '' }}"
                href="{{ route('admin.business-settings.email-setup', ['store','campaign-deny']) }}">
                    {{translate('Campaign_Join_Rejection')}}
                </a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>