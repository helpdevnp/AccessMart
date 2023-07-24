@extends('layouts.admin.app')

@section('title', translate('mail_config'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/email.png')}}" class="w--26" alt="">
                </span>
                <span>{{ translate('messages.smtp') }} {{ translate('messages.mail') }}
                        {{ translate('messages.setup') }}
                </span>
            </h1>
            @include('admin-views.business-settings.partials.third-party-links')
        </div>
        <!-- End Page Header -->
        
        <div class="card min-h-60vh">
            <div class="card-header card-header-shadow pb-0">
                <div class="d-flex flex-wrap justify-content-between w-100 row-gap-1">
                    <ul class="nav nav-tabs nav--tabs border-0 gap-2">
                        <li class="nav-item mr-2 mr-md-4">
                            <a href="{{route('admin.business-settings.third-party.mail-config')}}" class="nav-link pb-2 px-0 pb-sm-3 active">
                                <img src="{{asset('/public/assets/admin/img/mail-config.png')}}" alt="">
                                <span>{{translate('Mail Config')}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.business-settings.third-party.test')}}" class="nav-link pb-2 px-0 pb-sm-3">
                                <img src="{{asset('/public/assets/admin/img/test-mail.png')}}" alt="">
                                <span>{{translate('Send Test Mail')}}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <div class="text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#works-modal">
                            <strong class="mr-2">{{translate('How it Works')}}</strong>
                            <div class="blinkings">
                                <i class="tio-info-outined"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="mail-config">
                        @php($config = \App\Models\BusinessSetting::where(['key' => 'mail_config'])->first())
                        @php($data = $config ? json_decode($config['value'], true) : null)
                        
                        <form action="{{route('admin.business-settings.third-party.mail-config-status')}}"
                        method="post" id="mail-config-disable_form">
                        @csrf
                            <div class="form-group text-center d-flex flex-wrap align-items-center">
                                <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control mb-2">
                                    <span class="pr-1 d-flex align-items-center switch--label text--primary">
                                        <span class="line--limit-1">
                                            {{isset($data) && isset($data['status'])&&$data['status']==1?translate('Turn OFF'):translate('Turn ON')}}
                                        </span>
                                    </span>
                                    <input class="toggle-switch-input" id="mail-config-disable" type="checkbox" onclick="toogleStatusModal(event,'mail-config-disable','mail-success.png','mail-warning.png','{{translate('Important!')}}','{{translate('Warning!')}}',`<p>{{translate('Enabling mail configuration services will allow the system to send emails. Please ensure that you have correctly configured the SMTP settings to avoid potential issues with email delivery.')}}</p>`,`<p>{{translate('Disabling mail configuration services will prevent the system from sending emails. Please only turn off this service if you intend to temporarily suspend email sending. Note that this may affect system functionality that relies on email communication.')}}</p>`)" name="status" value="1" {{isset($data) && isset($data['status'])&&$data['status']==1?'checked':''}}>
                                    <span class="toggle-switch-label text p-0">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                                <small>{{translate('*By Turning OFF mail configuration, all your mailing services will be off.')}}</small>
                            </div>
                        </form>
                        <form action="javascript:"
                            method="post" id="mail-config-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="status" value="{{(isset($data)&& isset($data['status'])) ? $data['status']:0 }}">
                            <div class="disable-on-turn-of {{isset($data) && isset($data['status'])&&$data['status']==1?'':'inactive'}}">
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-0">
                                            <label class="form-label">{{ translate('messages.mailer') }}
                                                {{ translate('messages.name') }}</label><br>
                                            <input type="text" placeholder="{{ translate('messages.Ex:') }} Alex" class="form-control" name="name"
                                                value="{{ env('APP_MODE') != 'demo' ? $data['name'] ?? '' : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">{{ translate('messages.host') }}</label><br>
                                            <input type="text" class="form-control" name="host" placeholder="{{translate('messages.Ex_:_mail.6am.one')}}"
                                                value="{{ env('APP_MODE') != 'demo' ? $data['host'] ?? '' : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">{{ translate('messages.driver') }}</label><br>
                                            <input type="text" class="form-control" name="driver" placeholder="{{translate('messages.Ex : smtp')}}"
                                                value="{{ env('APP_MODE') != 'demo' ? $data['driver'] ?? '' : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">{{ translate('messages.port') }}</label><br>
                                            <input type="text" class="form-control" name="port" placeholder="{{translate('messages.Ex : 587')}}"
                                                value="{{ env('APP_MODE') != 'demo' ? $data['port'] ?? '' : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-0">
                                            <label class="form-label">{{ translate('messages.username') }}</label><br>
                                            <input type="text" placeholder="{{ translate('messages.Ex:') }} ex@yahoo.com" class="form-control" name="username"
                                                value="{{ env('APP_MODE') != 'demo' ? $data['username'] ?? '' : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">{{ translate('messages.email') }}
                                                {{ translate('messages.id') }}</label><br>
                                            <input type="text" placeholder="{{ translate('messages.Ex:') }} ex@yahoo.com" class="form-control" name="email"
                                                value="{{ env('APP_MODE') != 'demo' ? $data['email_id'] ?? '' : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">{{ translate('messages.encryption') }}</label><br>
                                            <input type="text" placeholder="{{ translate('messages.Ex:') }} tls" class="form-control" name="encryption"
                                                value="{{ env('APP_MODE') != 'demo' ? $data['encryption'] ?? '' : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">{{ translate('messages.password') }}</label><br>
                                            <input type="text" class="form-control" name="password" placeholder="{{translate('messages.Ex : 5+ Characters')}}"
                                                value="{{ env('APP_MODE') != 'demo' ? $data['password'] ?? '' : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="btn--container justify-content-end">
                                            <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                                            <button type="{{ env('APP_MODE') != 'demo' ? 'submit' : 'button' }}"
                                            onclick="{{ env('APP_MODE') != 'demo' ? '' : 'call_demo()' }}"
                                            class="btn btn--primary" 
                                            {{-- data-toggle="modal" data-target="#update-data-modal" --}}
                                            >{{ translate('messages.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mail Sent -->
    <div class="modal fade" id="sent-mail-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center mb-20">
                        <img src="{{asset('/public/assets/admin/img/sent-mail-box.png')}}" alt="" class="mb-20">
                        <h5 class="modal-title">{{translate('Congratulations! Your SMTP mail has been setup successfully!')}}</h5>
                        <p class="txt">
                            {{translate("Go to test mail to check that its work perfectly or not!")}}
                        </p>
                    </div>
                    <div class="btn--container justify-content-center">
                        <a href="{{route('admin.business-settings.third-party.test')}}" class="btn btn--primary min-w-120">
                            <img src="{{asset('/public/assets/admin/img/paper-plane.png')}}" alt=""> {{translate('Send Test Mail')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Data Modal -->
    <div class="modal fade" id="update-data-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center mb-20">
                        <img src="{{asset('/public/assets/admin/img/mail-config/save-data.png')}}" alt="" class="mb-20">
                        <h5 class="modal-title">{{translate('Send a Test Mail to Your Email ? ')}}</h5>
                        <p class="txt">
                            {{translate("A test mail will be send to your email to confirm it works perfectly.")}}
                        </p>
                    </div>
                    <div class="btn--container justify-content-center">
                        <button type="submit" class="btn btn--primary min-w-120" data-dismiss="modal">
                            {{translate('Send Test Mail')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How it Works Modal -->
    <div class="modal fade" id="works-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="single-item-slider owl-carousel">
                        <div class="item">
                            <div class="mb-20">
                                <div class="text-center">
                                    <img src="{{asset('/public/assets/admin/img/mail-config/slide-1.png')}}" alt="" class="mb-20">
                                    <h5 class="modal-title">{{translate('Find SMTP Server Details')}}</h5>
                                </div>
                                <ul>
                                    <li>
                                        {{translate('Contact your email service provider or IT administrator to obtain the SMTP server details, such as hostname, port, username, and password.')}}
                                    </li>
                                    <li>
                                        {{translate("Note: If you're not sure where to find these details, check the email provider's documentation or support resources for guidance.")}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mb-20">
                                <div class="text-center">
                                    <img src="{{asset('/public/assets/admin/img/mail-config/slide-2.png')}}" alt="" class="mb-20">
                                    <h5 class="modal-title">{{translate('Configure SMTP Settings')}}</h5>
                                </div>
                                <ul>
                                    <li>
                                        {{translate('Go to the SMTP mail setup page in the admin panel.')}}
                                    </li>
                                    <li>
                                        {{translate('Enter the obtained SMTP server details, including the hostname, port, username, and password.')}}
                                    </li>
                                    <li>
                                        {{translate('Choose the appropriate encryption method (e.g., SSL, TLS) if required. Save the settings.')}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mb-20">
                                <div class="text-center">
                                    <img src="{{asset('/public/assets/admin/img/mail-config/slide-3.png')}}" alt="" class="mb-20">
                                    <h5 class="modal-title">{{translate('Test SMTP Connection')}}</h5>
                                </div>
                                <ul>
                                    <li>
                                        {{translate('Click on the "Send Test Mail" button to verify the SMTP connection.')}}
                                    </li>
                                    <li>
                                        {{translate('If successful, you will see a confirmation message indicating that the connection is working fine.')}}
                                    </li>
                                    <li>
                                        {{translate('If not, double-check your SMTP settings and try again.')}}
                                    </li>
                                    <li>
                                        {{translate("Note: If you're unsure about the SMTP settings, contact your email service provider or IT administrator for assistance.")}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mw-353px mb-20 mx-auto">
                                <div class="text-center">
                                    <img src="{{asset('/public/assets/admin/img/mail-config/slide-4.png')}}" alt="" class="mb-20">
                                    <h5 class="modal-title">{{translate('Enable Mail Configuration')}}</h5>
                                </div>
                                <ul class="px-3">
                                    <li>
                                        {{translate('If the SMTP connection test is successful, you can now enable the mail configuration services by toggling the switch to "ON."')}}
                                    </li>
                                    <li>
                                        {{translate('This will allow the system to send emails using the configured SMTP settings.')}}
                                    </li>
                                </ul>
                                <div class="btn-wrap">
                                    <button type="submit" class="btn btn--primary w-100" data-dismiss="modal">{{translate('Got It')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="slide-counter"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script_2')

<script>
    const disableMailConf = () => {
        if($('#mail-config-disable').is(':checked')) {
            $('.disable-on-turn-of').removeClass('inactive')
        }else {
            $('.disable-on-turn-of').addClass('inactive')
        }
    }
    $('#mail-config-disable').on('change', function(){
        disableMailConf()
    })
</script>

    <script>
        $('#mail-config-form').submit(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.business-settings.third-party.mail-config') }}",
                method: 'POST',
                data: $('#mail-config-form').serialize(),
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    toastr.success('{{ translate('messages.configuration_updated_successfully') }}');
                    $('#sent-mail-modal').modal('show');
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        })
    </script>
@endpush
