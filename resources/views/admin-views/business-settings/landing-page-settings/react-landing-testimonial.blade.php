@extends('layouts.admin.app')

@section('title',translate('messages.react_landing_page'))

@section('content')
<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/landing.png')}}" class="w--20" alt="">
                </span>
                <span>
                    {{ translate('messages.react_landing_page') }}
                </span>
            </h1>
            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#how-it-works">
                <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                <div>
                    <i class="tio-info-outined"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            @include('admin-views.business-settings.landing-page-settings.top-menu-links.react-landing-page-links')
        </div>
    </div>
    @php($testimonial_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','testimonial_title')->first())
    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
    @php($language = $language->value ?? null)
    @php($default_lang = str_replace('_', '-', app()->getLocale()))
    @if($language)
        <ul class="nav nav-tabs mb-4 border-0">
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
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <form action="{{ route('admin.business-settings.react-landing-page-settings', 'testimonial-title') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-3">
                    <div class="card-body">
                        @if ($language)
                            <div class="row g-3 lang_form" id="default-form">
                                <div class="col-sm-12">
                                    <label class="form-label">{{translate('Title')}} ({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                        <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                    </span></label>
                            <input type="text"  maxlength="50" name="testimonial_title[]" class="form-control" value="{{$testimonial_title?->getRawOriginal('value')??''}}" placeholder="{{translate('messages.title_here...')}}">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                @foreach(json_decode($language) as $lang)
                                <?php
                                if(isset($testimonial_title->translations)&&count($testimonial_title->translations)){
                                        $testimonial_title_translate = [];
                                        foreach($testimonial_title->translations as $t)
                                        {   
                                            if($t->locale == $lang && $t->key=='testimonial_title'){
                                                $testimonial_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                
                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="{{$lang}}-form">
                                        <div class="col-sm-12">
                                            <label class="form-label">{{translate('Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="50" name="testimonial_title[]" class="form-control" value="{{ $testimonial_title_translate[$lang]['value']?? '' }}" placeholder="{{translate('messages.title_here...')}}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach
                            @else
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">{{translate('Title')}}</label>
                                        <input type="text" name="testimonial_title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            @endif
                        <div class="btn--container justify-content-end mt-3">
                            <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                            <button type="submit" onclick="" class="btn btn--primary mb-2">{{translate('Save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('admin.business-settings.react-landing-page-settings', 'testimonial-list') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{translate('Testimonial List Section')}}</span>
                </h5>
                <div class="card mb-3">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end">
                            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#testimonials-section">
                                <strong class="mr-2">{{translate('See_the_changes_here.')}}</strong>
                                <div>
                                    <i class="tio-intersect"></i>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{translate('Reviewer Name')}}</label>
                                        <input type="text" name="name" class="form-control" placeholder="{{translate('Ex:  John Doe')}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{translate('Designation')}}</label>
                                        <input type="text" name="designation" class="form-control" placeholder="{{translate('Ex:  CTO')}}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{translate('messages.review')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_140_characters') }}">
                                            <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                        </span></label>
                                        <textarea name="review"  maxlength="140" placeholder="{{translate('Very Good Company')}}" class="form-control h92px"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-40px">
                                    <div>
                                        <label class="form-label d-block mb-2">
                                            {{translate('Reviewer Image *')}}  <span class="text--primary">(1:1)</span>
                                        </label>
                                        <label class="upload-img-3 m-0 d-block">
                                            <div class="img">
                                                <img src="" onerror="this.src='{{asset("/public/assets/admin/img/aspect-1.png")}}'" class="img__aspect-1 min-w-187px max-w-187px" alt="">
                                            </div>
                                            <input type="file"  name="reviewer_image" hidden="">
                                        </label>
                                    </div>
                                    {{-- <div class="d-flex flex-column">
                                        <label class="form-label d-block mb-2">
                                            {{translate('Company Logo *')}}  <span class="text--primary">(3:1)</span>
                                        </label>
                                        <label class="upload-img-4 m-0 d-block my-auto">
                                            <div class="img">
                                                <img src="" onerror="this.src='{{asset("/public/assets/admin/img/aspect-3-1.png")}}'" class="vertical-img min-w-187px max-w-187px" alt="">
                                            </div>
                                            <input type="file" id="image-upload-2" name="company_image" hidden="">
                                        </label>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-3">
                            <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                            <button type="submit" onclick="" class="btn btn--primary mb-2">{{translate('Add')}}</button>
                        </div>
                        
                    </div>
                </form>
                    @php($reviews=\App\Models\ReactTestimonial::all())
                    <div class="card-body p-0">
                        <!-- Table -->
                        <div class="table-responsive datatable-custom">
                            <table class="table table-borderless table-thead-bordered table-align-middle table-nowrap card-table m-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-top-0">{{translate('SL')}}</th>
                                        <th class="border-top-0">{{translate('Reviewer Name')}}</th>
                                        <th class="border-top-0">{{translate('Designation')}}</th>
                                        <th class="border-top-0">{{translate('Reviews')}}</th>
                                        <th class="text-center border-top-0">{{translate('Reviewer Image')}}</th>
                                        {{-- <th class="text-center border-top-0">{{translate('Company Image')}}</th> --}}
                                        <th class="text-center border-top-0">{{translate('Status')}}</th>
                                        <th class="text-center border-top-0">{{translate('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $key=>$review)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            <div class="text--title">
                                            {{ $review->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text--title">
                                            {{ $review->designation }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="word-break">
                                                {{ $review->review }}
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{asset('storage/app/public/reviewer_image')}}/{{$review->reviewer_image}}"
                                            onerror="this.src='{{asset('/public/assets/admin/img/upload-3.png')}}'" class="__size-105" alt="">
                                        </td>
                                        {{-- <td>
                                            <img src="{{asset('storage/app/public/reviewer_company_image')}}/{{$review->company_image}}"
                                            onerror="this.src='{{asset('/public/assets/admin/img/upload-3.png')}}'" class="__size-105" alt="">
                                        </td> --}}
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm">
                                                <input type="checkbox" class="toggle-switch-input" onclick="toogleStatusModal(event,'status-{{$review->id}}','this-review-on.png','this-review-off.png','{{translate('By Turning ON ')}} <strong>{{translate('This review')}}','{{translate('By Turning OFF ')}} <strong>{{translate('This review')}}',`<p>{{translate('This section will be enabled. You can see this section on your landing page.')}}</p>`,`<p>{{translate('This section  will be disabled. You can enable it in the settings')}}</p>`)" id="status-{{$review->id}}" {{$review->status?'checked':''}}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <form action="{{route('admin.business-settings.review-react-status',[$review->id,$review->status?0:1])}}" method="get" id="status-{{$review->id}}_form">
                                            </form>
                                        </td>
                
                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--primary btn-outline-primary" href="{{route('admin.business-settings.review-react-edit',[$review['id']])}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                                onclick="form_alert('review-{{$review['id']}}','{{ translate('Want to delete this review ?') }}')" title="{{translate('messages.delete')}} {{translate('messages.review')}}"><i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="{{route('admin.business-settings.review-react-delete',[$review['id']])}}" method="post" id="review-{{$review['id']}}">
                                                    @csrf @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                
                        </div>
                        <!-- End Table -->
                    </div>
                    @if(count($reviews) === 0)
                    <div class="empty--data">
                        <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                        <h5>
                            {{translate('no_data_found')}}
                        </h5>
                    </div>
                    @endif
                </div>
        
        
            <!--  Special review Section View -->
            <div class="modal fade" id="testimonials-section">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3">{{translate(' Special review')}}</h3>
                            </div>
                            <img src="{{asset('/public/assets/admin/img/zone-instruction.png')}}" alt="admin/img" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Testimonial Modal -->
            <div class="modal fade" id="testimonials-status-modal">
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
                                        <img src="{{asset('/public/assets/admin/img/modal/this-review-off.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning OFF ')}} <strong>{{translate('This review')}}</strong></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('This section  will be disabled. You can enable it in the settings')}}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div>
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/this-review-on.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning ON ')}} <strong>{{translate('This review')}}</strong></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('This section will be enabled. You can see this section on your landing page.')}}
                                        </p>
                                    </div>
                                </div> -->
                                <div class="btn--container justify-content-center">
                                    <button type="submit" class="btn btn--primary min-w-120" data-dismiss="modal">{{translate('Ok')}}</button>
                                    <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">                
                                        {{translate("Cancel")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- How it Works -->
    @include('admin-views.business-settings.landing-page-settings.partial.how-it-work-react')
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
        $("#"+lang+"-form1").removeClass('d-none');
        if(lang == '{{$default_lang}}')
        {
            $(".from_part_2").removeClass('d-none');
        }
        if(lang == 'default')
        {
            $(".default-form").removeClass('d-none');
        }
        else
        {
            $(".from_part_2").addClass('d-none');
        }
    });
</script>
@endpush
