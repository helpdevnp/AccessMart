
@extends('layouts.vendor.app')
@section('title',translate('messages.edit_store'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
     <!-- Custom styles for this page -->
     <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">
     <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <!-- Content Row -->
    <div class="content container-fluid">
        <div class="page-header">
            <h2 class="page-header-title text-capitalize">
                <img class="w--26" src="{{asset('/public/assets/admin/img/store.png')}}" alt="public">
                <span>
                    {{translate('messages.edit')}} {{translate('messages.store')}} {{translate('messages.info')}}
                </span>
            </h1>
        </div>
        @php($language=\App\Models\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        @php($default_lang = 'en')
        <form action="{{route('vendor.shop.update')}}" method="post"
                enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @if($language)
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active"
                                    href="#"
                                    id="default-link">{{ translate('Default') }}</a>
                                </li>
                                @foreach (json_decode($language) as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link"
                                            href="#"
                                            id="{{ $lang }}-link">{{ \App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                            <div class="col-12">
                                    @if ($language)
                                    <div class="lang_form"
                                    id="default-form">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="default_name">{{ translate('messages.name') }}
                                                ({{ translate('messages.Default') }})
                                            </label>
                                            <input type="text" name="name[]" id="default_name"
                                                class="form-control" placeholder="{{ translate('messages.store_name') }}" value="{{$shop->getRawOriginal('name')}}"
                                                
                                                oninvalid="document.getElementById('en-link').click()">
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                        <div class="form-group mb-0">
                                            <label class="input-label"
                                                for="exampleFormControlInput1">{{ translate('messages.address') }} ({{ translate('messages.default') }})</label>
                                            <textarea type="text" name="address[]" placeholder="{{translate('messages.store')}}" class="form-control min-h-90px ckeditor">{{$shop->getRawOriginal('address')}}</textarea>
                                        </div>
                                    </div>
                                        @foreach (json_decode($language) as $lang)
                                        <?php
                                            if(count($shop['translations'])){
                                                $translate = [];
                                                foreach($shop['translations'] as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=="name"){
                                                        $translate[$lang]['name'] = $t->value;
                                                    }
                                                    if($t->locale == $lang && $t->key=="address"){
                                                        $translate[$lang]['address'] = $t->value;
                                                    }
                                                }
                                            }
                                        ?>
                                            <div class="d-none lang_form"
                                                id="{{ $lang }}-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="{{ $lang }}_name">{{ translate('messages.name') }}
                                                        ({{ strtoupper($lang) }})
                                                    </label>
                                                    <input type="text" name="name[]" id="{{ $lang }}_name"
                                                        class="form-control" value="{{ $translate[$lang]['name']??'' }}" placeholder="{{ translate('messages.store_name') }}"
                                                        oninvalid="document.getElementById('en-link').click()">
                                                </div>
                                                <input type="hidden" name="lang[]" value="{{ $lang }}">
                                                <div class="form-group mb-0">
                                                    <label class="input-label"
                                                        for="exampleFormControlInput1">{{ translate('messages.address') }} ({{ strtoupper($lang) }})</label>
                                                    <textarea type="text" name="address[]" placeholder="{{translate('messages.store')}}" class="form-control min-h-90px ckeditor">{{ $translate[$lang]['address']??'' }}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1">{{ translate('messages.name') }} ({{ translate('messages.default') }})</label>
                                                <input type="text" name="name[]" class="form-control"
                                                    placeholder="{{ translate('messages.store_name') }}" required>
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1">{{ translate('messages.address') }}
                                                </label>
                                                <textarea type="text" name="address[]" placeholder="{{translate('messages.store')}}" class="form-control min-h-90px ckeditor"></textarea>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- <div class="form-group">
                                        <label for="name">{{translate('messages.store')}} {{translate('messages.name')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{$shop->name}}" class="form-control" id="name"
                                                required>
                                    </div> --}}
                                    <div class="form-group mt-2">
                                        <label for="name">{{translate('messages.contact')}} {{translate('messages.number')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="contact" value="{{$shop->phone}}" class="form-control" id="name"
                                                required>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">{{translate('messages.address')}}<span class="text-danger">*</span></label>
                                        <textarea type="text" rows="4" name="address" value="" class="form-control" id="address"
                                                required>{{$shop->address}}</textarea>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title font-regular">
                                {{translate('messages.upload')}} {{translate('messages.logo')}}
                            </h5>
                        </div>
                        <div class="card-body d-flex flex-column pt-0">
                            <center class="my-auto py-4 py-xl-5">
                                <img class="store-banner" id="viewer"
                                onerror="this.src='{{asset('public/assets/admin/img/image-place-holder.png')}}'"
                                src="{{asset('storage/app/public/store/'.$shop->logo)}}" alt="Product thumbnail"/>
                            </center>
                            <div class="custom-file">
                                <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="customFileUpload">{{translate('messages.choose')}} {{translate('messages.file')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title font-regular">
                                {{translate('messages.upload')}} {{translate('messages.cover')}} {{translate('messages.photo')}} <span class="text-danger">({{translate('messages.ratio')}} 2:1)</span>
                            </h5>
                        </div>
                        <div class="card-body d-flex flex-column pt-0">
                            <center class="my-auto py-4 py-xl-5">
                                <img class="store-banner" id="coverImageViewer"
                                onerror="this.src='{{asset('public/assets/admin/img/restaurant_cover.jpg')}}'"
                                src="{{asset('storage/app/public/store/cover/'.$shop->cover_photo)}}" alt="Product thumbnail"/>
                            </center>
                            <div class="custom-file">
                                <input type="file" name="photo" id="coverImageUpload" class="custom-file-input"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="coverImageUpload">{{translate('messages.choose')}} {{translate('messages.file')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 justify-content-end btn--container">
                <a class="btn btn--danger text-capitalize" href="{{route('vendor.shop.view')}}">{{translate('messages.cancel')}}</a>
                <button type="submit" class="btn btn--primary text-capitalize" id="btn_update">{{translate('messages.update')}}</button>
            </div>
        </form>
    </div>
@endsection

@push('script_2')
<script>
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
            $(".from_part_2").removeClass('d-none');
        }
        else
        {
            $(".from_part_2").addClass('d-none');
        }
    });
</script>

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

        $("#coverImageUpload").change(function () {
            readURL(this, 'coverImageViewer');
        });

        $("#customFileUpload").change(function () {
            readURL(this, 'viewer');
        });
   </script>
@endpush
