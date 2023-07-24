@extends('layouts.admin.app')

@section('title', translate('email_template'))


@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="{{ asset('public/assets/admin/img/email-setting.png') }}" class="w--26" alt="">
                </span>
                <span>
                    {{ translate('messages.Email Templates') }}
                </span>
            </h1>
            @include('admin-views.business-settings.partials.email-template-setting-links')
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="admin_registration">
                @include('admin-views.business-settings.email-format-setting.admin-registration-format')
            </div>
            <div class="tab-pane fade" id="forgot_pass">
                @include('admin-views.business-settings.email-format-setting.forgot-pass-format')
            </div>
            <div class="tab-pane fade" id="store_registration">
                @include('admin-views.business-settings.email-format-setting.store-registration-format')
            </div>
        </div>

        
        <!-- Instructions Modal -->
@include('admin-views.business-settings.email-format-setting.partials.email-template-instructions')

    </div>

@endsection

@push('script_2')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
