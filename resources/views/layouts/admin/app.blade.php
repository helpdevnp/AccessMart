<!DOCTYPE html>
<?php
    $site_direction = session()->get('site_direction');
    // if (env('APP_MODE') == 'demo') {
    //     $site_direction = session()->get('site_direction');
    // }else{
    //     $site_direction = \App\Models\BusinessSetting::where('key', 'site_direction')->first();
    //     $site_direction = $site_direction->value ?? 'ltr';
    // }

?>
<html dir="{{ $site_direction }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $site_direction === 'rtl'?'active':'' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>@yield('title')</title>
    <!-- Favicon -->
    @php($logo=\App\Models\BusinessSetting::where(['key'=>'icon'])->first()->value)
    <link rel="shortcut icon" href="">
    <link rel="icon" type="image/x-icon" href="{{asset('storage/app/public/business/'.$logo??'')}}">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/vendor.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/vendor/icon-set/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/custom.css')}}">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/theme.minc619.css?v=1.0')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/bootstrap-tour-standalone.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/emogi-area.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/admin/css/style.css')}}">
    @stack('css_or_js')

    <script
        src="{{asset('public/assets/admin')}}/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script>
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/toastr.css">
</head>

<body class="footer-offset">
    @if (env('APP_MODE')=='demo')
    <div class="direction-toggle">
        <i class="tio-settings"></i>
        <span></span>
    </div>  
    @endif

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" class="initial-hidden">
                <div class="loader--inner">
                    <img width="200" src="{{asset('public/assets/admin/img/loader.gif')}}">
                </div>
            </div>
        </div>
    </div>
</div>
@if (!isset($module_type))   
@php($module_type = Config::get('module.current_module_type'))
@endif
<!-- Builder -->
@include('layouts.admin.partials._front-settings')
<!-- End Builder -->

<!-- JS Preview mode only -->
@include('layouts.admin.partials._header')

@include("layouts.admin.partials._sidebar_{$module_type}")

<!-- END ONLY DEV -->

<main id="content" role="main" class="main pointer-event">
    <!-- Content -->
@yield('content')
<!-- End Content -->

    <!-- Footer -->
@include('layouts.admin.partials._footer')
<!-- End Footer -->

    <div class="modal fade" id="popup-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <center>
                                <h2>
                                    <i class="tio-shopping-cart-outlined"></i> {{translate('messages.You have new order, Check Please.')}}
                                </h2>
                                <hr>
                                <button onclick="check_order()" class="btn btn-primary">{{translate('messages.Ok, let me check')}}</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="toggle-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img id="toggle-image" alt="" class="mb-20">
                                <h5 class="modal-title" id="toggle-title"></h5>
                            </div>
                            <div class="text-center" id="toggle-message">
                            </div>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button type="button" id="toggle-ok-button" class="btn btn--primary min-w-120" data-dismiss="modal" onclick="confirmToggle()">{{translate('Ok')}}</button>
                            <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">                
                                {{translate("Cancel")}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="toggle-status-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img id="toggle-status-image" alt="" class="mb-20">
                                <h5 class="modal-title" id="toggle-status-title"></h5>
                            </div>
                            <div class="text-center" id="toggle-status-message">
                            </div>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button type="button" id="toggle-status-ok-button" class="btn btn--primary min-w-120" data-dismiss="modal" onclick="confirmStatusToggle()">{{translate('Ok')}}</button>
                            <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">                
                                {{translate("Cancel")}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="instruction-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" onclick="instructionModalClose()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/0sus46BflpU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="email-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" onclick="emailModalClose()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/_BIHsClZtOE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                      </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->

{{--<nav class="floating-menu">
    <ul class="main-menu">
        @foreach (\App\Models\Module::notParcel()->get() as $module)
        <li>
            <a class="p-2 navbar-dropdown-account-wrapper" href="javascript:;" onclick="set_filter('{{url()->full()}}',{{$module->id}},'module_id')" title="{{$module->module_name}}">
                <img class="avatar avatar-sm avatar-circle" src="{{asset('storage/app/public/module')}}/{{$module['thumbnail']}}" alt="{{$module->module_name}}" width="20">
            </a>
        </li>
        @endforeach
        <li>
            <a class="p-2 navbar-dropdown-account-wrapper" href="javascript:;" onclick="set_filter('{{url()->full()}}','','module_id')" title="{{$module->module_name}}">
                <img class="avatar avatar-sm avatar-circle" src="{{asset('storage/app/public/business/'.$logo??'')}}" alt="{{translate('messages.all')}} {{translate('messages.module')}}" width="20">
            </a>
        </li>
    </ul>
    <div class="menu-bg"></div>
</nav>--}}
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== END SECONDARY CONTENTS ========== -->
<script src="{{asset('public/assets/admin')}}/js/custom.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<!-- JS Implementing Plugins -->

@stack('script')
<!-- JS Front -->
<script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/sweet_alert.js"></script>
<script src="{{asset('public/assets/admin')}}/js/bootstrap-tour-standalone.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/"></script>
<script src="{{asset('public/assets/admin/js/owl.min.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"></script>
<script src="{{asset('public/assets/admin')}}/js/emogi-area.js"></script>
<script src="{{asset('public/assets/admin')}}/js/toastr.js"></script>

<script>
    $('.blinkings').on('mouseover', ()=> $('.blinkings').removeClass('active'))
    $('.blinkings').addClass('open-shadow')
    setTimeout(() => {
        $('.blinkings').removeClass('active')
    }, 10000);
    setTimeout(() => {
        $('.blinkings').removeClass('open-shadow')
    }, 5000);
</script>
<script>
    $(function(){
        var owl = $('.single-item-slider');
        owl.owlCarousel({
            autoplay: false,
            items:1,
            onInitialized  : counter,
            onTranslated : counter,
            autoHeight: true,
            dots: true
        });

        function counter(event) {
            var element   = event.target;         // DOM element, in this example .owl-carousel
                var items     = event.item.count;     // Number of items
                var item      = event.item.index + 1;     // Position of the current item
            
            // it loop is true then reset counter from 1
            if(item > items) {
                item = item - items
            }
            $('.slide-counter').html(+item+"/"+items)
        }
    });
</script>


{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
<!-- JS Plugins Init. -->
<script>
    $(document).on('ready', function () {
        // ONLY DEV
        // =======================================================
        if (window.localStorage.getItem('hs-builder-popover') === null) {
            $('#builderPopover').popover('show')
                .on('shown.bs.popover', function () {
                    $('.popover').last().addClass('popover-dark')
                });

            $(document).on('click', '#closeBuilderPopover', function () {
                window.localStorage.setItem('hs-builder-popover', true);
                $('#builderPopover').popover('dispose');
            });
        } else {
            $('#builderPopover').on('show.bs.popover', function () {
                return false
            });
        }
        // END ONLY DEV
        // =======================================================

        // BUILDER TOGGLE INVOKER
        // =======================================================
        $('.js-navbar-vertical-aside-toggle-invoker').click(function () {
            $('.js-navbar-vertical-aside-toggle-invoker i').tooltip('hide');
        });

        // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
        // =======================================================
        var sidebar = $('.js-navbar-vertical-aside').hsSideNav();


        // INITIALIZATION OF TOOLTIP IN NAVBAR VERTICAL MENU
        // =======================================================
        $('.js-nav-tooltip-link').tooltip({boundary: 'window'})

        $(".js-nav-tooltip-link").on("show.bs.tooltip", function (e) {
            if (!$("body").hasClass("navbar-vertical-aside-mini-mode")) {
                return false;
            }
        });


        // INITIALIZATION OF UNFOLD
        // =======================================================
        $('.js-hs-unfold-invoker').each(function () {
            var unfold = new HSUnfold($(this)).init();
        });


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        $('.js-form-search').each(function () {
            new HSFormSearch($(this)).init()
        });


        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function () {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });


        // INITIALIZATION OF DATERANGEPICKER
        // =======================================================
        $('.js-daterangepicker').daterangepicker();

        $('.js-daterangepicker-times').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'M/DD hh:mm A'
            }
        });

        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#js-daterangepicker-predefined .js-daterangepicker-predefined-preview').html(start.format('MMM D') + ' - ' + end.format('MMM D, YYYY'));
        }

        $('#js-daterangepicker-predefined').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);


        // INITIALIZATION OF CLIPBOARD
        // =======================================================
        $('.js-clipboard').each(function () {
            var clipboard = $.HSCore.components.HSClipboard.init(this);
        });
    });
</script>

@stack('script_2')

<script>
    @php($modules = \App\Models\Module::Active()->get())
    var tour = new Tour({
        backdrop: true,
        delay: true,
        redirect: true,
        name:'tour',
        steps: [
            {
                element: "#tourb-0",
                title: "Module",
                placement: 'right',
                content: "From here you can switch to multiple modules."
            },
            {
                element: "#tourb-1",
                title: "Module Selection",
                content: "You can select a module from here.",
                onNext: function(){
                    document.location.href = "{{ route('admin.dashboard') }}?module_id={{count($modules)>0?$modules[0]->id:1}}";
                } 
            },
            {
                element: "#navbar-vertical-content",
                title: "Module Sidebar",
                content: "This is the module wise sidebar."
            },
            {
                element: "#tourb-3",
                title: "Settings",
                content: "From here you can go to settings option."
            },
            {
                element: "#tourb-4",
                title: "Settings Menu",
                content: "From here you can select any settings option.",   
                onNext: function(){
                    document.location.href = "{{ route('admin.business-settings.business-setup') }}";
                } 
            },
            {
                element: "#navbar-vertical-content",
                title: "Settings Sidebar",
                content: "This is the settings sidebar. Different from module",
            },
            {
                element: "#tourb-6",
                title: "User Section",
                content: "You can manage all the users by selecting this option.",
            },
            {
                element: "#tourb-7",
                title: "Transaction and Report",
                content: "You can manage all the Transaction and Report by selecting this option."
            },
            {
                element: "#tourb-8",
                title: "Dispatch Management",
                content: "You can manage all dispatch orders by selecting this option."
            },
            {
                element: "#tourb-9",
                title: "Profile and Logout",
                content: "You can visit your profile or logut from this panel.",
                placement:'top'
            }
        ],
        onEnd: function() {
            $('body').css('overflow','')
        },
        onShow: function() {
            $('body').css('overflow','hidden')
        }
    });

    // Initialize the tour
    // tour.init();
    
    @if(isset($modules) && ($modules->count()<1))
    $('#instruction-modal').show();
        // Start the tour
        // tour.start();
        // $('body').css('overflow','hidden')
    @endif
    @if(isset($modules) && ($modules->count()>0))
        // Start the tour
        // tour.start();
        // $('body').css('overflow','hidden')
    @endif

    function restartTour() {
        @if(isset($modules) && ($modules->count()>0))
            // Start the tour
            tour.restart();
            $('body').css('overflow','hidden')
        @endif
    }


    
</script>
<audio id="myAudio">
    <source src="{{asset('public/assets/admin/sound/notification.mp3')}}" type="audio/mpeg">
</audio>

<script>
    var audio = document.getElementById("myAudio");

    function playAudio() {
        audio.play();
    }

    function pauseAudio() {
        audio.pause();
    }
</script>
<script>
    
    function instructionModalClose() {
        $('#instruction-modal').hide();
        tour.init();
        tour.start();
    }
    function instructionModalShow() {
        $('#instruction-modal').show();
    }
    function emailModalClose() {
        $('#email-modal').hide();
    }
    function emailModalShow() {
        $('#email-modal').show();
    }
    function route_alert(route, message, title="{{translate('messages.are_you_sure')}}") {
        Swal.fire({
            title: title,
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '{{ translate('messages.no') }}',
            confirmButtonText: '{{ translate('messages.Yes') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = route;
            }
        })
    }

    function form_alert(id, message) {
        Swal.fire({
            title: '{{ translate('messages.Are you sure?') }}',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '{{ translate('messages.no') }}',
            confirmButtonText: '{{ translate('messages.Yes') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#'+id).submit()
            }
        })
    }
    function form_alert_title(id,title, message) {
        Swal.fire({
            title: title,
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '{{ translate('messages.no') }}',
            confirmButtonText: '{{ translate('messages.Yes') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#'+id).submit()
            }
        })
    }
    function set_zone_filter(url, id) {
        var nurl = new URL(url);
        nurl.searchParams.set('zone_id', id);

        location.href = nurl;
    }

    function set_store_filter(url, id) {
        var nurl = new URL(url);
        nurl.searchParams.set('store_id', id);
        location.href = nurl;
    }
    function set_category_filter(url, id) {
        var nurl = new URL(url);
        nurl.searchParams.set('category_id', id);
        location.href = nurl;
    }

    function set_time_filter(url, id) {
        var nurl = new URL(url);
        nurl.searchParams.set('filter', id);
        location.href = nurl;
    }

    function set_customer_filter(url, id) {
        var nurl = new URL(url);
        nurl.searchParams.set('customer_id', id);
        location.href = nurl;
    }


    function set_filter(url, id, filter_by) {
        var nurl = new URL(url);
        nurl.searchParams.set(filter_by, id);
        location.href = nurl;
        tour.next();
    }

    function change_mail_route(value) {
        if(value == 'admin'){
            var url= '{{url('/')}}/admin/business-settings/email-setup/'+value+'/forgot-password';
        }else{
            var url= '{{url('/')}}/admin/business-settings/email-setup/'+value+'/registration';
        }
        location.href = url;
    }

    function set_mail_filter(url, id, filter_by) {
        Swal.fire({
            title: '{{ translate('messages.Are you sure?') }}',
            text: 'Please save changes before switching template',
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '{{ translate('messages.no') }}',
            confirmButtonText: '{{ translate('messages.Yes') }}',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                var nurl = new URL(url);
                nurl.searchParams.set(filter_by, id);
                location.href = nurl;
            }
        })
    }

    function next_tour() {
        tour.next();
    }

    function copy_text(copyText) {
        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText);

        toastr.success('{{translate('messages.text_copied')}}', {
            CloseButton: true,
            ProgressBar: true
        });
    }
</script>
<script>
    $(document).ready(function(){
        $('button[type=submit]').on("click", function(){
            setTimeout(function () {
                $('button[type=submit]').prop('disabled', true);
                }, 0);
            setTimeout(function () {
                $('button[type=submit]').prop('disabled', false);
                }, 1000);
        });
    });

    $(document).on('ready', function(){
        // $('body').css('overflow','')
        $(".direction-toggle").on("click", function () {
            if($('html').hasClass('active')){
                $('html').removeClass('active')
                setDirection(1);
            }else {
                setDirection(0);
                $('html').addClass('active')
            }
        });
        if ($('html').attr('dir') == "rtl") {
            $(".direction-toggle").find('span').text('Toggle LTR')
        } else {
            $(".direction-toggle").find('span').text('Toggle RTL')
        }

        function setDirection(status) {
            if (status == 1) {
                $("html").attr('dir', 'ltr');
                $(".direction-toggle").find('span').text('Toggle RTL')
            } else {
                $("html").attr('dir', 'rtl');
                $(".direction-toggle").find('span').text('Toggle LTR')
            }
            $.get({
                    url: '{{ route('admin.business-settings.site_direction') }}',
                    dataType: 'json',
                    data: {
                        status: status,
                    },
                    success: function() {
                        alert(ok);
                    },

                });
            }
        });

</script>
<script>
    @php($fcm_credentials = \App\CentralLogics\Helpers::get_business_settings('fcm_credentials'))
    var firebaseConfig = {
        apiKey: "{{isset($fcm_credentials['apiKey']) ? $fcm_credentials['apiKey'] : ''}}",
        authDomain: "{{isset($fcm_credentials['authDomain']) ? $fcm_credentials['authDomain'] : ''}}",
        projectId: "{{isset($fcm_credentials['projectId']) ? $fcm_credentials['projectId'] : ''}}",
        storageBucket: "{{isset($fcm_credentials['storageBucket']) ? $fcm_credentials['storageBucket'] : ''}}",
        messagingSenderId: "{{isset($fcm_credentials['messagingSenderId']) ? $fcm_credentials['messagingSenderId'] : ''}}",
        appId: "{{isset($fcm_credentials['appId']) ? $fcm_credentials['appId'] : ''}}",
        measurementId: "{{isset($fcm_credentials['measurementId']) ? $fcm_credentials['measurementId'] : ''}}"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function startFCM() {

        messaging
            .requestPermission()
            .then(function() {
                return messaging.getToken()
            })
            .then(function(response) {
                subscribeTokenToTopic(response, 'admin_message');
                console.log('subscribed');
            }).catch(function(error) {
                console.log(error);
            });
    }
    @php($key = \App\Models\BusinessSetting::where('key', 'push_notification_key')->first())

    function subscribeTokenToTopic(token, topic) {
        fetch('https://iid.googleapis.com/iid/v1/' + token + '/rel/topics/' + topic, {
            method: 'POST',
            headers: new Headers({
                'Authorization': 'key={{ $key ? $key->value : '' }}'
            })
        }).then(response => {
            if (response.status < 200 || response.status >= 400) {
                throw 'Error subscribing to topic: ' + response.status + ' - ' + response.text();
            }
            console.log('Subscribed to "' + topic + '"');
        }).catch(error => {
            console.error(error);
        })
    }

    function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }
    }

    function conversationList() {
        $.ajax({
                url: "{{ route('admin.message.list') }}",
                success: function(data) {
                    $('#conversation-list').empty();
                    $("#conversation-list").append(data.html);
                    var user_id = getUrlParameter('user');
                $('.customer-list').removeClass('conv-active');
                $('#customer-' + user_id).addClass('conv-active');
                }
            })
    }

    function conversationView() {
        var conversation_id = getUrlParameter('conversation');
        var user_id = getUrlParameter('user');
        var url= '{{url('/')}}/admin/message/view/'+conversation_id+'/' + user_id;
        $.ajax({
            url: url,
            success: function(data) {
                $('#view-conversation').html(data.view);
            }
        })
    }



    function vendorConversationView() {
        var conversation_id = getUrlParameter('conversation');
        var user_id = getUrlParameter('user');
        var url= '{{url('/')}}/admin/store/message/'+conversation_id+'/' + user_id;
        $.ajax({
            url: url,
            success: function(data) {
                $('#vendor-view-conversation').html(data.view);
            }
        })
    }

    function dmConversationView() {
        var conversation_id = getUrlParameter('conversation');
        var user_id = getUrlParameter('user');
        var url= '{{url('/')}}/admin/delivery-man/message/'+conversation_id+'/' + user_id;
        $.ajax({
            url: url,
            success: function(data) {
                $('#dm-view-conversation').html(data.view);
            }
        })
    }

    var new_order_type='store_order';
    var new_module_id=null;
    var admin_zone_id=null;
    var admin_role_id=null;

    messaging.onMessage(function(payload) {
        console.log(payload.data);
        if(payload.data.order_id && payload.data.type == "order_request"){
                @php($admin_order_notification = \App\Models\BusinessSetting::where('key', 'admin_order_notification')->first())
                @php($admin_order_notification = $admin_order_notification ? $admin_order_notification->value : 0)
                @if (\App\CentralLogics\Helpers::module_permission_check('order') && $admin_order_notification)
                new_order_type = payload.data.order_type
                new_module_id = payload.data.module_id
                admin_zone_id = '<?php echo auth()->guard('admin')->user()->zone_id ;?>';
                admin_role_id = '<?php echo auth()->guard('admin')->user()->role_id ;?>';
                if(admin_role_id == '1'){
                    playAudio();
                    $('#popup-modal').appendTo("body").modal('show');
                }
                if((admin_role_id != '1') && (admin_zone_id == payload.data.zone_id)){
                    playAudio();
                    $('#popup-modal').appendTo("body").modal('show');
                }
                @endif
   
        }else{
            var conversation_id = getUrlParameter('conversation');
            var user_id = getUrlParameter('user');
            var url= '{{url('/')}}/admin/message/view/'+conversation_id+'/' + user_id;
            console.log(url);
            $.ajax({
                url: url,
                success: function(data) {
                    $('#view-conversation').html(data.view);
                }
            })
            toastr.success('New message arrived', {
                CloseButton: true,
                ProgressBar: true
            });
            if($('#conversation-list').scrollTop() == 0){
                conversationList();
            }
        }
    });

    function check_order() {
            if(new_order_type == 'parcel')
            {
                var url= '{{url('/')}}/admin/parcel/orders/all?module_id=' + new_module_id;
                location.href = url;
            }
            else
            {
                var url= '{{url('/')}}/admin/order/list/all?module_id=' + new_module_id;
                location.href = url;
            }

        }

    startFCM();
    conversationList();
    if(getUrlParameter('conversation')){
        conversationView();
        vendorConversationView();
        dmConversationView();
    }
</script>

<script>
    function toogleModal(e, toggle_id, on_image, off_image, on_title, off_title, on_message, off_message) {
        e.preventDefault();
        if ($('#'+toggle_id).is(':checked')) {
            $('#toggle-title').empty().append(on_title);
            $('#toggle-message').empty().append(on_message);
            $('#toggle-image').attr('src', "{{asset('/public/assets/admin/img/modal')}}/"+on_image);
            $('#toggle-ok-button').attr('toggle-ok-button', toggle_id);
        } else {
            $('#toggle-title').empty().append(off_title);
            $('#toggle-message').empty().append(off_message);
            $('#toggle-image').attr('src', "{{asset('/public/assets/admin/img/modal')}}/"+off_image);
            $('#toggle-ok-button').attr('toggle-ok-button', toggle_id);
        }
        $('#toggle-modal').modal('show');
    }

    function confirmToggle() {
        var toggle_id = $('#toggle-ok-button').attr('toggle-ok-button');
        if ($('#'+toggle_id).is(':checked')) {
            $('#'+toggle_id).prop('checked', false);
        } else {
            $('#'+toggle_id).prop('checked', true);
        }
        $('#toggle-modal').modal('hide');
     
        if(toggle_id == 'free_delivery_over_status'){
            if ($("#free_delivery_over_status").is(':checked')) {
                $('#free_delivery_over').removeAttr('readonly');
            } else {
                $('#free_delivery_over').attr('readonly', true);
                $('#free_delivery_over').val(null);
            }
        }
            
    }

    function toogleStatusModal(e, toggle_id, on_image, off_image, on_title, off_title, on_message, off_message) {
        e.preventDefault();
        if ($('#'+toggle_id).is(':checked')) {
            $('#toggle-status-title').empty().append(on_title);
            $('#toggle-status-message').empty().append(on_message);
            $('#toggle-status-image').attr('src', "{{asset('/public/assets/admin/img/modal')}}/"+on_image);
            $('#toggle-status-ok-button').attr('toggle-ok-button', toggle_id);
        } else {
            $('#toggle-status-title').empty().append(off_title);
            $('#toggle-status-message').empty().append(off_message);
            $('#toggle-status-image').attr('src', "{{asset('/public/assets/admin/img/modal')}}/"+off_image);
            $('#toggle-status-ok-button').attr('toggle-ok-button', toggle_id);
        }
        $('#toggle-status-modal').modal('show');
    }

    function confirmStatusToggle() {
        var toggle_id = $('#toggle-status-ok-button').attr('toggle-ok-button');
        if ($('#'+toggle_id).is(':checked')) {
            $('#'+toggle_id).prop('checked', false);
            $('#'+toggle_id).val(0);
        } else {
            $('#'+toggle_id).prop('checked', true);
            $('#'+toggle_id).val(1);
        }
        $('#'+toggle_id+'_form').submit();
            
    }

    function checkMailElement(id) {
        console.log(id);
        if ($('.'+id).is(':checked')) {
            $('#'+id).show();
        } else {
            $('#'+id).hide();
        }
    }
</script>

<script>
    function call_demo(){
        toastr.info('{{ translate('Update option is disabled for demo!') }}', {
            CloseButton: true,
            ProgressBar: true
        });
    }
</script>

<script>
    $(document).ready(function() {
        "use strict"
        $(".upload-img-3, .upload-img-4, .upload-img-2, .upload-img-5, .upload-img-1, .upload-img").each(function(){
            var targetedImage = $(this).find('.img');
            var targetedImageSrc = $(this).find('.img img');
            function proPicURL(input) {
                if (input.files && input.files[0]) {
                    var uploadedFile = new FileReader();
                    uploadedFile.onload = function (e) {
                        targetedImageSrc.attr('src', e.target.result);
                        targetedImage.addClass('image-loaded');
                        targetedImage.hide();
                        targetedImage.fadeIn(650);
                    }
                    uploadedFile.readAsDataURL(input.files[0]);
                }
            }
            $(this).find('input').on('change', function () {
                proPicURL(this);
            })
        })
    });
</script>


<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{asset('public/assets/admin')}}/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
</body>
</html>
