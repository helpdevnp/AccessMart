<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link  {{ Request::is('admin/business-settings/business-setup') ?'active':'' }}" href="{{ route('admin.business-settings.business-setup') }}"   aria-disabled="true">{{translate('messages.business')}} {{translate('messages.information')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/business-setup/order') ?'active':'' }}" href="{{ route('admin.business-settings.business-setup',  ['tab' => 'order']) }}"  aria-disabled="true">{{translate('messages.order_settings')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/business-setup/refund-settings') ?'active':'' }}" href="{{ route('admin.business-settings.business-setup',  ['tab' => 'refund-settings']) }}"  aria-disabled="true">{{translate('messages.refund_settings')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/business-setup/store') ?'active':'' }}" href="{{ route('admin.business-settings.business-setup',  ['tab' => 'store']) }}"  aria-disabled="true">{{translate('messages.stores')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/business-setup/deliveryman') ?'active':'' }}" href="{{ route('admin.business-settings.business-setup',  ['tab' => 'deliveryman']) }}"  aria-disabled="true">{{translate('messages.delivery')}} {{translate('messages.man')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/business-setup/customer') ?'active':'' }}" href="{{ route('admin.business-settings.business-setup',  ['tab' => 'customer']) }}"  aria-disabled="true">{{translate('messages.customers')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/business-settings/language') ?'active':'' }}" href="{{route('admin.business-settings.language.index')}}"  aria-disabled="true">{{translate('messages.Languages')}}</a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
    @if (!Request::is('admin/business-settings/language'))
    <div class="d-flex flex-wrap justify-content-end align-items-center flex-grow-1">
        <div class="blinkings active">
            <i class="tio-info-outined"></i>
            <div class="business-notes">
                <h6><img src="{{asset('/public/assets/admin/img/notes.png')}}" alt=""> {{translate('Note')}}</h6>
                <div>
                    @if (Request::is('admin/business-settings/business-setup/refund-settings'))
                    {{ translate('messages.*If_the_Admin_enables_the_‘Refund_Request_Mode’,_customers_can_request_a_refund.') }}
                    @else
                    {{translate('messages.don’t_forget_to_click_the_‘Save Information’_button_below_to_save_changes.')}}
                    @endif      
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>