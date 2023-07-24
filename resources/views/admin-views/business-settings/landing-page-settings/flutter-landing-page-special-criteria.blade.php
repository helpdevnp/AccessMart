@extends('layouts.admin.app')

@section('title',translate('messages.flutter_web_landing_page'))

@section('content')

<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/flutter.png')}}" class="w--20" alt="">
                </span>
                <span>
                    {{ translate('messages.flutter_web_landing_page') }}
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
            @include('admin-views.business-settings.landing-page-settings.top-menu-links.flutter-landing-page-links')
        </div>
    </div>
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
                <form action="{{ route('admin.business-settings.flutter-landing-page-settings', 'special-criteria-list') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span>{{translate('Special_Feature_List_Section ')}}</span>
                </h5>
                <div class="card mb-3">
                    <div class="card-body">
                            {{-- <div class="d-flex justify-content-end">
                                <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#criteria-section">
                                    <strong class="mr-2">{{translate('See_the_changes_here.')}}</strong>
                                    <div>
                                        <i class="tio-intersect"></i>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row g-3">
                                @if ($language)
                                <div class="col-sm-6 lang_form default-form">
                                    <label class="form-label">{{translate('Title')}} ({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_30_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="30" name="title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                    @foreach(json_decode($language) as $lang)
                                    <div class="col-sm-6 d-none lang_form" id="{{$lang}}-form1">
                                        <label class="form-label">{{translate('Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_30_characters') }}">
                                            <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                        </span></label>
                                <input type="text"  maxlength="30" name="title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                    </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                    @endforeach
                                @else
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_30_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="30" name="title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                @endif
                                <div class="col-sm-6">
                                    <div>

                                        <label class="form-label">{{translate('Criteria Icon/ Image')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Icon_ratio_(1:1)_and_max_size_2_MB.') }}">
                                            <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                        </span></label>
                                    </div>
                                    <label class="upload-img-3 m-0">
                                        <div class="img">
                                            <img src="{{asset('/public/assets/admin/img/aspect-1.png')}}" alt="" class="img__aspect-1 min-w-187px max-w-187px">
                                        </div>
                                          <input type="file"  name="image" hidden>
                                    </label>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-3">
                                <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                                <button type="submit" onclick="" class="btn btn--primary mb-2">{{translate('Add')}}</button>
                            </div>
                        </div>
                    </form>
                    @php($criterias=\App\Models\FlutterSpecialCriteria::all())
                    <div class="card-body p-0">
                        <!-- Table -->
                        <div class="table-responsive datatable-custom">
                            <table id="columnSearchDatatable"
                                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    data-hs-datatables-options='{
                                        "order": [],
                                        "orderCellsTop": true,
                                        "paging":false
                
                                    }'>
                                <thead class="thead-light">
                                <tr>
                                    <th class="border-0">{{translate('sl')}}</th>
                                    <th class="border-0">{{translate('Title')}}</th>
                                    <th class="border-0">{{translate('Image')}}</th>
                                    <th class="border-0">{{translate('Status')}}</th>
                                    <th class="text-center border-0">{{translate('messages.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($criterias as $key=>$criteria)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            <div class="text--title">
                                            {{ $criteria->title }}
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{asset('storage/app/public/special_criteria')}}/{{$criteria->image}}"
                                            onerror="this.src='{{asset('/public/assets/admin/img/upload-3.png')}}'" class="__size-105" alt="">
                                        </td>
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm">
                                                <input type="checkbox" class="toggle-switch-input" onclick="toogleStatusModal(event,'status-{{$criteria->id}}','this-criteria-on.png','this-criteria-off.png','{{translate('messages.Want_to_enable')}} <strong>{{translate('this_feature?')}}','{{translate('messages.Want_to_disable')}} <strong>{{translate('this_feature?')}}',`<p>{{translate('If_yes,_it_will_be_available_on_the_landing_page.')}}</p>`,`<p>{{translate('If_yes,_it_will_be_hidden_from_the_landing_page.')}}</p>`)" id="status-{{$criteria->id}}" {{$criteria->status?'checked':''}}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <form action="{{route('admin.business-settings.flutter-criteria-status',[$criteria->id,$criteria->status?0:1])}}" method="get" id="status-{{$criteria->id}}_form">
                                            </form>
                                        </td>
                
                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--primary btn-outline-primary" href="{{route('admin.business-settings.flutter-criteria-edit',[$criteria['id']])}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                                onclick="form_alert_title('criteria-{{$criteria['id']}}','{{ translate('Want_to_delete_this_feature_?') }}','{{translate('If_yes,_It_will_be_removed_from_this_list_and_the_landing_page.')}}')" title="{{translate('messages.delete')}} {{translate('messages.criteria')}}"><i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="{{route('admin.business-settings.flutter-criteria-delete',[$criteria['id']])}}" method="post" id="criteria-{{$criteria['id']}}">
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
                    @if(count($criterias) === 0)
                    <div class="empty--data">
                        <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                        <h5>
                            {{translate('no_data_found')}}
                        </h5>
                    </div>
                    @endif
                </div>
        
        
            <!--  Special Criteria Section View -->
            <div class="modal fade" id="criteria-section">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3">{{translate(' Special Criteria')}}</h3>
                            </div>
                            <img src="{{asset('/public/assets/admin/img/zone-instruction.png')}}" alt="admin/img" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Single Criteria Modal -->
            <div class="modal fade" id="single-criteria-modal">
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
                                        <img src="{{asset('/public/assets/admin/img/modal/this-criteria-off.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning OFF ')}} <strong>{{translate('This Criteria')}}</strong></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{translate('This section  will be disabled. You can enable it in the settings')}}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div>
                                    <div class="text-center">
                                        <img src="{{asset('/public/assets/admin/img/modal/this-criteria-on.png')}}" alt="" class="mb-20">
                                        <h5 class="modal-title">{{translate('By Turning ON ')}} <strong>{{translate('This Criteria')}}</strong></h5>
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
    @include('admin-views.business-settings.landing-page-settings.partial.how-it-work-flutter')
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
