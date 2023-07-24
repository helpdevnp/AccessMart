@extends('layouts.admin.app')

@section('title',translate('messages.landing_page_image_settings'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header pb-0">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="{{asset('public/assets/admin/img/landing.png')}}" class="w--26" alt="">
            </span>
            <span>
                {{ translate('messages.landing_page_settings') }}
            </span>
        </h1>
    </div>
    <div class="mb-5">
        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <!-- Nav -->
            @include('admin-views.business-settings.landing-page-settings.top-menu-links.top-menu-links')
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
    </div>
        <!-- End Page Header -->

    <div class="card mb-3">
        <div class="card-body landing-page-images">
            @php($download_app_section = \App\Models\BusinessSetting::where(['key'=>'download_app_section'])->first())
            @php($download_app_section = isset($download_app_section->value)?json_decode($download_app_section->value, true):null)
            @php($counter = \App\Models\BusinessSetting::where(['key'=>'counter_section'])->first())
            @php($counter = isset($counter->value)?json_decode($counter->value, true):null)
            <div class="row gy-4">
                <div class="col-sm-12 col-xl-12">
                    <form action="{{route('admin.business-settings.landing-page-settings', 'download-section')}}" id="tnc-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-xl-6">
                                <div class="form-group">
                                    <label class="input-label">{{ translate('messages.text')}}</label>
                                    <textarea class="form-control" name="description" rows="8">{!! $download_app_section['description'] ?? '' !!}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-6">
                                <div class="form-group">
                                    <label class="input-label" >{{translate('messages.image')}}<small class="text-danger"> * ( {{translate('messages.size')}}: 514 X 378 px )</small></label>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileEg" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileEg">{{translate('messages.choose')}} {{translate('messages.file')}}</label>
                                    </div>

                                    <center id="image-viewer-section" class="pt-4">
                                        <img class="img--200 border" id="viewer" src="{{asset('public/assets/landing')}}/image/{{isset($download_app_section['img'])?$download_app_section['img']:'double_screen_image.png'}}"
                                                onerror="this.src='{{asset('public/assets/admin/img/400x400/img2.jpg')}}'"
                                                alt=""/>
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="btn--container justify-content-end">
                            <button type="reset" id="reset-button" class="btn btn--reset">{{translate('messages.reset')}}</button>
                            <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12 col-xl-12">
                <div
                class="card my-2">
                <div class="card-header">
                    <h3 class="mt-2 mb-3">Download buttons</h3>
                </div>
                   <div class="card-body">
                       <form action="{{ route('admin.business-settings.landing-page-settings', 'app-download-button') }}" method="POST"
                           enctype="multipart/form-data">
                           @php($button = \App\Models\BusinessSetting::where(['key' => 'app_download_button'])->first())
                           @php($button = isset($button->value) ? json_decode($button->value, true) : [])
                           @csrf
       
                           <div
       
                           class="row gy-3">
                               <div class="col-lg-6">
                                   <div class="form-group">
                                       <label class="input-label" for="button_text">{{ translate('messages.button_text') }}</label>
                                       <input type="text" id="button_text" name="button_text" class="form-control h--45px"
                                           placeholder="{{ translate('Ex: Button text') }}">
                                   </div>
                               </div>
                               <div class="col-lg-6">
                                   <div class="form-group">
                                       <label class="input-label" for="link">{{ translate('messages.link') }}</label>
                                       <input type="url" id="link" name="link" class="form-control h--45px"
                                           placeholder="{{ translate('Ex: Link') }}">
                                   </div>
                               </div>
                           </div>
                           <div
                            class="form-group mt-3">
                               <div class="btn--container justify-content-end">
                                   <button type="submit" class="btn btn--primary">{{ translate('messages.submit') }}</button>
                               </div>
                           </div>
       
                       </form>
                   </div>
                       <div class="col-12">
                           <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                               <thead>
                                   <tr>
                                       <th scope="col">{{ translate('messages.sl') }}</th>
                                       <th scope="col">{{ translate('messages.button_text') }}</th>
                                       <th scope="col">{{ translate('messages.link') }}</th>
                                       <th scope="col" class="text-center">{{ translate('messages.action') }}</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @if ($button)
                                       @foreach ($button as $key => $button_item)
                                           <tr>
                                               <th scope="row">{{ $key + 1 }}</th>
                                               <td>{{ $button_item['button_text'] }}</td>
                                               <td>{{ $button_item['link'] }}</td>
                                               <td>
                                                   <div class="btn--container justify-content-center">
                                                       <a class="btn btn--danger btn-outline-danger action-btn" href="javascript:"
                                                           onclick="form_alert('feature-{{ $key }}','{{ translate('messages.Want_to_delete_this_item') }}')"
                                                           data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.delete') }}"><i class="tio-delete-outlined"></i>
                                                       </a>
                                                   </div>
                                                   <form
                                                       action="{{ route('admin.business-settings.landing-page-settings-delete', ['tab' => 'app_download_button', 'key' => $key]) }}"
                                                       method="post" id="feature-{{ $key }}">
                                                       @csrf
                                                       @method('delete')
                                                   </form>
                                               </td>
                                           </tr>
                                       @endforeach
                                   @endif
                               </tbody>
                           </table>
                           @if(!$button )
                           <div class="empty--data">
                               <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                               <h5>
                                   {{translate('no_data_found')}}
                               </h5>
                           </div>
                           @endif
                       </div>
               </div>
               </div>
                <div class="col-sm-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mt-2 mb-3">Counter Section</h3>
                            <form action="{{route('admin.business-settings.landing-page-settings', 'counter-section')}}" id="tnc-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4 col-xl-4">
                                        <div class="form-group">
                                            <label class="input-label">{{ translate('messages.app_download_count_numbers')}}</label>
                                            <input class="form-control" value="{{ $counter['app_download_count_numbers'] ?? '' }}" name="app_download_count_numbers">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xl-4">
                                        <div class="form-group">
                                            <label class="input-label">{{ translate('messages.seller_count_numbers')}}</label>
                                            <input class="form-control" name="seller_count_numbers" value="{{ $counter['deliveryman_count_numbers'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xl-4">
                                        <div class="form-group">
                                            <label class="input-label">{{ translate('messages.deliveryman_count_numbers')}}</label>
                                            <input class="form-control" value="{{ $counter['deliveryman_count_numbers'] ?? '' }}" name="deliveryman_count_numbers">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="btn--container justify-content-end">
                                    <button type="reset" id="reset-button" class="btn btn--reset">{{translate('messages.reset')}}</button>
                                    <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <script>
        function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+viewer).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg").change(function () {
            readURL(this, 'viewer');
            $('#image-viewer-section').show(1000);
        });

    </script>
@endpush
