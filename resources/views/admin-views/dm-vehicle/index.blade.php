@extends('layouts.admin.app')

@section('title',translate('messages.add_vehicle_category'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="tio-add-circle-outlined"></i></div>
                        {{translate('messages.add_vehicle_category')}}
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.users.delivery-man.vehicle.store')}}" method="post" enctype="multipart/form-data" id="vehicle-form">
                    @csrf
                    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                    @php($language = $language->value ?? null)
                    @php($default_lang = str_replace('_', '-', app()->getLocale()))
                    @if($language)
                        <ul class="nav nav-tabs mb-4">
                            <li class="nav-item">
                                <a class="nav-link lang_link active"
                                href="#"
                                id="default-link">{{translate('messages.default')}}</a>
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
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    @if ($language)
                                    <div class="form-group lang_form" id="default-form">
                                        <label class="input-label text-capitalize" for="title">{{translate('messages.Vehicle')}} {{translate('messages.type')}} ({{ translate('messages.default') }})</label>
                                        <input type="text" name="type[]" class="form-control h--45px" placeholder="{{translate('messages.ex_:_bike')}}" maxlength="191" required oninvalid="document.getElementById('en-link').click()">
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                        @foreach(json_decode($language) as $lang)
                                            <div class="form-group d-none lang_form" id="{{$lang}}-form">
                                                <label class="input-label text-capitalize" for="title">{{translate('messages.Vehicle')}} {{translate('messages.type')}} ({{strtoupper($lang)}})</label>
                                                <input type="text" name="type[]" class="form-control h--45px" placeholder="{{translate('messages.ex_:_bike')}}" maxlength="191" oninvalid="document.getElementById('en-link').click()">
                                            </div>
                                            <input type="hidden" name="lang[]" value="{{$lang}}">
                                        @endforeach
                                    @else
                                        <div class="form-group">
                                            <label class="input-label text-capitalize" for="title">{{translate('messages.Vehicle')}} {{translate('messages.type')}}</label>
                                            <input type="text" name="type" class="form-control h--45px" placeholder="{{translate('messages.ex_:_bike')}}" required maxlength="191">
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="input-label text-capitalize" for="title">{{translate('messages.extra_charges')}} ({{ \App\CentralLogics\Helpers::currency_symbol() }}) <span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{translate('This amount will be added with delivery charge')}}"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="public/img"></span></label>
                                        <input type="number" id="extra_charges" class="form-control h--45px" step="0.001" min="0" required name="extra_charges">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="input-label text-capitalize" for="title">{{translate('messages.minimum_coverage_area')}} ({{ translate('messages.km') }}) <span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{translate('This value is the minimum distance for a vehicle in this category to serve an order.')}}"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="public/img"></span></label>
                                        <input type="number" id="starting_coverage_area" class="form-control h--45px" step="0.001" min="0" required name="starting_coverage_area">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="input-label text-capitalize" for="title">{{translate('messages.maximum_coverage_area')}} ({{ translate('messages.km') }}) <span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{translate('This value is the miximum distance for a vehicle in this category to serve an order.
                                            ')}}"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="public/img"></span></label>
                                        <input type="number" id="maximum_coverage_area" class="form-control h--45px" step="0.001" min="0"  required name="maximum_coverage_area">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="btn--container justify-content-end">
                        <button type="reset" id="reset_btn" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });

        $('#vehicle-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.users.delivery-man.vehicle.store')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{ translate('messages.Vehicle_category_created') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '{{route('admin.users.delivery-man.vehicle.list')}}';
                        }, 1000);
                    }
                }
            });
        });

    </script>

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
            $('#reset_btn').click(function(){
                $('#choice_item').val(null).trigger('change');
                $('#viewer').attr('src','{{asset('public/assets/admin/img/900x400/img1.jpg')}}');
            })
        </script>
@endpush
