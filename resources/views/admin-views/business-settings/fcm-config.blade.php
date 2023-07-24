@extends('layouts.admin.app')

@section('title',translate('FCM Settings'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/firebase.png')}}" class="w--26" alt="">
                </span>
                <span>{{translate('messages.firebase')}} {{translate('messages.push')}} {{translate('messages.notification')}} {{translate('messages.setup')}}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <?php 
        $mod_type = 'grocery';
        if(request('module_type')){
            $mod_type = request('module_type');
        }
        ?>
        <div class="card">
            <div class="card-header card-header-shadow pb-0">
                <div class="d-flex flex-wrap justify-content-between w-100 row-gap-1">
                    <ul class="nav nav-tabs nav--tabs border-0 gap-2">
                        <li class="nav-item mr-2 mr-md-4">
                            <a href="{{ route('admin.business-settings.fcm-index') }}" class="nav-link pb-2 px-0 pb-sm-3" data-slide="1">
                                <img src="{{asset('/public/assets/admin/img/notify.png')}}" alt="">
                                <span>{{translate('Push Notification')}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.business-settings.fcm-config') }}" class="nav-link pb-2 px-0 pb-sm-3 active" data-slide="2">
                                <img src="{{asset('/public/assets/admin/img/firebase2.png')}}" alt="">
                                <span>{{translate('Firebase Configuration')}}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <div class="tab--content">
                            <div class="item text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#push-notify-modal">
                                <strong class="mr-2">{{translate('Read Documentation')}}</strong>
                                <div class="blinkings">
                                    <i class="tio-info-outined"></i>
                                </div>
                            </div>
                            <div class="item show text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#firebase-modal">
                                <strong class="mr-2">{{translate('Where to get this information')}}</strong>
                                <div class="blinkings">
                                    <i class="tio-info-outined"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="firebase">
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.update-fcm'):'javascript:'}}" method="post"
                                enctype="multipart/form-data">
                            @csrf
                            @php($key=\App\Models\BusinessSetting::where('key','push_notification_key')->first())
                            <div class="form-group">
                                <label class="input-label"
                                        for="exampleFormControlInput1">{{translate('messages.server')}} {{translate('messages.key')}}</label>
                                <textarea name="push_notification_key" class="form-control" placeholder="{{translate('Ex: AAAAaBcDeFgHiJkLmNoPqRsTuVwXyZ0123456789')}}"
                                            required>{{env('APP_MODE')!='demo'?$key->value??'':''}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.api_key')}}</label>
                                <div class="d-flex">
                                    <input type="text" value="{{isset($fcm_credentials['apiKey'])?$fcm_credentials['apiKey']:''}}"
                                        name="apiKey" class="form-control" placeholder="{{ translate('Ex: abcd1234efgh5678ijklmnop90qrstuvwxYZ') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                    @php($project_id=\App\Models\BusinessSetting::where('key','fcm_project_id')->first())
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('FCM Project ID')}}</label>
                                        <div class="d-flex">
                                            <input type="text" value="{{$project_id->value??''}}"
                                                name="projectId" class="form-control" placeholder="{{ translate('Ex: my-awesome-app-12345') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.auth_domain')}}</label>
                                        <div class="d-flex">
                                            <input type="text" value="{{isset($fcm_credentials['authDomain'])?$fcm_credentials['authDomain']:''}}"
                                                name="authDomain" class="form-control" placeholder="{{ translate('Ex: my-awesome-app.firebaseapp.com') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.storage_bucket')}}</label>
                                        <div class="d-flex">
                                            <input type="text" value="{{isset($fcm_credentials['storageBucket'])?$fcm_credentials['storageBucket']:''}}"
                                                name="storageBucket" class="form-control" placeholder="{{ translate('Ex: my-awesome-app.appspot.com') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.messaging_sender_id')}}</label>
                                        <div class="d-flex">
                                            <input type="text" value="{{isset($fcm_credentials['messagingSenderId'])?$fcm_credentials['messagingSenderId']:''}}"
                                                name="messagingSenderId" class="form-control" placeholder="{{ translate('Ex: 1234567890') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.app_id')}}</label>
                                        <div class="d-flex">
                                            <input type="text" value="{{isset($fcm_credentials['appId'])?$fcm_credentials['appId']:''}}"
                                                name="appId" class="form-control" placeholder="{{ translate('Ex: 9876543210') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.measurement_id')}}</label>
                                        <div class="d-flex">
                                            <input type="text" value="{{isset($fcm_credentials['measurementId'])?$fcm_credentials['measurementId']:''}}"
                                                name="measurementId" class="form-control" placeholder="{{ translate('Ex: F-12345678') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn--primary">{{translate('messages.submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Firebase Modal -->
        <div class="modal fade" id="firebase-modal">
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
                                        <img src="{{asset('/public/assets/admin/img/firebase/slide-1.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('Go to Firebase Console')}}</h5>
                                    </div>
                                    <ul>
                                        <li>
                                            {{translate('Open your web browser and go to the Firebase Console')}}
                                            <a href="#" class="text--underline">
                                                {{translate('(https://console.firebase.google.com/)')}}
                                            </a>
                                        </li>
                                        <li>
                                            {{translate("Select the project for which you want to configure FCM from the Firebase Console dashboard.")}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item">
                                <div class="mb-20">
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/firebase/slide-2.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('Navigate to Project Settings')}}</h5>
                                    </div>
                                    <ul>
                                        <li>
                                            {{translate('In the left-hand menu, click on the "Settings" gear icon, and then select "Project settings" from the dropdown.')}}
                                        </li>
                                        <li>
                                            {{translate('In the Project settings page, click on the "Cloud Messaging" tab from the top menu.')}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item">
                                <div class="mb-20">
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/firebase/slide-3.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('Obtain All The Information Asked!')}}</h5>
                                    </div>
                                    <ul>
                                        <li>
                                            {{translate('In the Firebase Project settings page, click on the "General" tab from the top menu.')}}
                                        </li>
                                        <li>
                                            {{translate('Under the "Your apps" section, click on the "Web" app for which you want to configure FCM.')}}
                                        </li>
                                        <li>
                                            {{translate('Then Obtain API Key, FCM Project ID, Auth Domain, Storage Bucket, Messaging Sender ID.')}}
                                        </li>
                                    </ul>
                                    <p>
                                        {{translate('Note: Please make sure to use the obtained information securely and in accordance with Firebase and FCM documentation, terms of service, and any applicable laws and regulations.')}}
                                    </p>
                                    <div class="btn-wrap">
                                        <button type="submit" class="btn btn--primary w-100" data-dismiss="modal" data-toggle="modal" data-target="#firebase-modal-2">{{translate('Got It')}}</button>
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
        <!-- Firebase Modal -->
        <div class="modal fade" id="push-notification-modal">
            <div class="modal-dialog status-warning-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true" class="tio-clear"></span>
                        </button>
                    </div>
                    <div class="modal-body pb-5 pt-0">
                        <div class="max-349 mx-auto mb-20">
                            <div class="text-center">
                                <img src="{{asset('/public/assets/admin/img/firebase/slide-4.png')}}" alt="" class="mb-20">
                                <h5 class="modal-title">{{translate('Please Visit the Docs to Set FCM on Mobile Apps')}}</h5>
                            </div>
                            <div class="text-center">
                                <p>
                                    {{translate('Please check the documentation below for detailed instructions on setting up your mobile app to receive Firebase Cloud Messaging (FCM) notifications.')}}
                                </p>
                                <a href="#">{{translate('Click Here')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Order Status Modal -->
        <div class="modal fade" id="order-status-modal">
            <div class="modal-dialog status-warning-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true" class="tio-clear"></span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="text-center mb-20">
                            <!-- Warning Content -->
                            <!-- <img src="{{asset('/public/assets/admin/img/modal/pending-order-off.png')}}" alt="" class="mb-20">
                            <h5 class="modal-title">{{translate('By Turning OFF Order ')}}<strong class="font-bold">{{translate('Pending Message')}}</strong></h5>
                            <p class="txt">
                                {{translate("User can't get a clear message to know that order is pending or not")}}
                            </p> -->
                            <!-- Success Content -->
                            <img src="{{asset('/public/assets/admin/img/modal/pending-order-on.png')}}" alt="" class="mb-20">
                            <h5 class="modal-title">{{translate('By Turning ON Order ')}} <strong class="font-bold">{{translate('Pending Message')}}</strong></h5>
                            <p class="txt">
                                {{translate("User will get a clear message to know that order is pending")}}
                            </p>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button type="submit" class="btn btn--primary min-w-120" data-dismiss="modal">{{translate('Ok')}}</button>
                            <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">{{translate("Cancel")}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')

<script>
    $('[data-slide]').on('click', function(){
        let serial = $(this).data('slide')
        $(`.tab--content .item`).removeClass('show')
        $(`.tab--content .item:nth-child(${serial})`).addClass('show')
    })
</script>


<script>

    function checkedFunc() {
        $('.switch--custom-label .toggle-switch-input').each( function() {
            if(this.checked) {
                $(this).closest('.switch--custom-label').addClass('checked')
            }else {
                $(this).closest('.switch--custom-label').removeClass('checked')
            }
        })
    }
    checkedFunc()
    $('.switch--custom-label .toggle-switch-input').on('change', checkedFunc)

</script>
{{-- <script>
    $(".lang_link").click(function(e){
        e.preventDefault();
        $(".lang_link").removeClass('active');
        $(".lang_form").addClass('d-none');
        $(this).addClass('active');

        let form_id = this.id;
        let lang = form_id.substring(0, form_id.length - 5);
        console.log(lang);
        $("#"+lang+"-form").removeClass('d-none');
        if(lang == '{{$default_lang}}')
        {
            $("#from_part_2").removeClass('d-none');
        }
        else
        {
            $("#from_part_2").addClass('d-none');
        }
    })
</script> --}}

<script>
    function add_required_attribute(status, name, lang_en){
        if($('#'+status).is(':checked')){
            $('#en-form .'+name).attr('required', true);
        } else {
            $('#en-form .'+name).removeAttr('required');
        }
    }
</script>

@endpush
