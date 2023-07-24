@extends('layouts.admin.app')

@section('title', translate('messages.admin_landing_page'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header pb-0">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="page-header-title">
                    <span class="page-header-icon">
                        <img src="{{ asset('public/assets/admin/img/landing.png') }}" class="w--20" alt="">
                    </span>
                    <span>
                        {{ translate('messages.admin_landing_pages') }}
                    </span>
                </h1>
                <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal"
                    data-target="#how-it-works">
                    <strong class="mr-2">{{ translate('How the Setting Works') }}</strong>
                    <div>
                        <i class="tio-info-outined"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4 mt-2">
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                @include('admin-views.business-settings.landing-page-settings.top-menu-links.admin-landing-page-links')
            </div>
        </div>
        @php($feature_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key', 'feature_title')->first())
        @php($feature_short_description = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key', 'feature_short_description')->first())
        @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
        @php($language = $language->value ?? null)
        @php($default_lang = str_replace('_', '-', app()->getLocale()))
        @if ($language)
            <ul class="nav nav-tabs mb-4 border-0">
                <li class="nav-item">
                    <a class="nav-link lang_link active" href="#"
                        id="default-link">{{ translate('messages.default') }}</a>
                </li>
                @foreach (json_decode($language) as $lang)
                    <li class="nav-item">
                        <a class="nav-link lang_link" href="#"
                            id="{{ $lang }}-link">{{ \App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
        <div class="tab-content">
            <div class="tab-pane fade show active">
                <form action="{{ route('admin.business-settings.admin-landing-page-settings', 'feature-title') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5 class="card-title mb-3">
                        <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span>
                        <span>{{ translate('Feature Title & Short Description') }}</span>
                    </h5>
                    <div class="card mb-3">
                        <div class="card-body">
                            {{-- <div class="d-flex justify-content-end">
                                <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button"
                                    data-toggle="modal" data-target="#admin-feature-sectin-view">
                                    <strong class="mr-2">{{ translate('See_the_changes_here.') }}</strong>
                                    <div>
                                        <i class="tio-intersect"></i>
                                    </div>
                                </div>
                            </div> --}}
                            @if ($language)
                                <div class="row g-3 lang_form default-form">
                                    <div class="col-sm-6">
                                        <label class="form-label">{{ translate('Title') }}
                                            ({{ translate('messages.default') }})<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                    alt="">
                                            </span></label>
                                        <input type="text" maxlength="80" name="feature_title[]"
                                            value="{{ $feature_title?->getRawOriginal('value') }}" class="form-control"
                                            placeholder="{{ translate('Ex_:_Remarkable_Features_that_You_Can_Count') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">{{ translate('Short Description') }}
                                            ({{ translate('messages.default') }})<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ translate('Write_the_title_within_240_characters') }}">
                                                <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                    alt="">
                                            </span></label>
                                        <input type="text" maxlength="240" name="feature_short_description[]"
                                            value="{{ $feature_short_description?->getRawOriginal('value') }}" class="form-control"
                                            placeholder="{{ translate('Ex_:_Jam-packed_with_outstanding_features…') }}">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                @foreach (json_decode($language) as $lang)
                                    <?php
                                    if (isset($feature_title->translations) && count($feature_title->translations)) {
                                        $feature_title_translate = [];
                                        foreach ($feature_title->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'feature_title') {
                                                $feature_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    if (isset($feature_short_description->translations) && count($feature_short_description->translations)) {
                                        $feature_short_description_translate = [];
                                        foreach ($feature_short_description->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'feature_short_description') {
                                                $feature_short_description_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="{{ $lang }}-form">
                                        <div class="col-sm-6">
                                            <label class="form-label">{{ translate('Title') }}
                                                ({{ strtoupper($lang) }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                        <input type="text"  maxlength="80" name="feature_title[]"
                                                value="{{ $feature_title_translate[$lang]['value'] ?? '' }}"
                                                class="form-control"
                                                placeholder="{{ translate('Ex_:_Remarkable_Features_that_You_Can_Count') }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">{{ translate('Short Description') }}
                                                ({{ strtoupper($lang) }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_240_characters') }}">
                                                <img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                        <input type="text"  maxlength="240" name="feature_short_description[]"
                                                value="{{ $feature_short_description_translate[$lang]['value'] ?? '' }}"
                                                class="form-control"
                                                placeholder="{{ translate('Ex_:_Jam-packed_with_outstanding_features…') }}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{ $lang }}">
                                @endforeach
                            @else
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">{{ translate('Title') }}<span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                    alt="">
                                            </span></label>
                                        <input type="text" maxlength="80" name="feature_title[]" class="form-control"
                                            placeholder="{{ translate('Ex_:_Remarkable_Features_that_You_Can_Count') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">{{ translate('Short Description') }}<span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ translate('Write_the_title_within_240_characters') }}">
                                                <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                    alt="">
                                            </span></label>
                                        <input type="text" maxlength="240" name="feature_short_description[]"
                                            class="form-control"
                                            placeholder="{{ translate('Ex_:_Jam-packed_with_outstanding_features…') }}">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            @endif
                            <div class="btn--container justify-content-end mt-3">
                                <button type="reset" class="btn btn--reset">{{ translate('Reset') }}</button>
                                <button type="submit" onclick=""
                                    class="btn btn--primary mb-2">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{ route('admin.business-settings.admin-landing-page-settings', 'feature-list') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-4">
                                @if ($language)
                                    <div class="col-md-6 lang_form default-form">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">{{ translate('Title') }}
                                                    ({{ translate('messages.default') }})<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="20" name="title[]" class="form-control"
                                                    placeholder="{{ translate('Ex_:_Shopping') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">{{ translate('Sub Title') }}
                                                    ({{ translate('messages.default') }})<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="80" name="sub_title[]"
                                                    class="form-control"
                                                    placeholder="{{ translate('Ex_:_Best_shopping_experience') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    @foreach (json_decode($language) as $lang)
                                        <div class="col-md-6 d-none lang_form" id="{{ $lang }}-form1">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">{{ translate('Title') }}
                                                        ({{ strtoupper($lang) }})<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_20_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="20" name="title[]" class="form-control"
                                                        placeholder="{{ translate('Ex_:_Shopping') }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">{{ translate('Sub Title') }}
                                                        ({{ strtoupper($lang) }})<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="80" name="sub_title[]" class="form-control"
                                                        placeholder="{{ translate('Ex_:_Best_shopping_experience') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{ $lang }}">
                                    @endforeach
                                @else
                                    <div class="col-md-6">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">{{ translate('Title') }}<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="50" name="title[]" class="form-control"
                                                    placeholder="{{ translate('Ex_:_Shopping') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">{{ translate('Sub Title') }}<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="{{ translate('Write_the_title_within_50_characters') }}">
                                                        <img src="{{ asset('public/assets/admin/img/info-circle.svg') }}"
                                                            alt="">
                                                    </span></label>
                                                <input type="text" maxlength="50" name="sub_title[]"
                                                    class="form-control"
                                                    placeholder="{{ translate('Ex_:_Best_shopping_experience') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                @endif

                                <div class="col-md-6">
                                    <label class="form-label d-block mb-2">
                                        {{ translate('messages.Image') }} <span class="text--primary">(size: 1:1)</span>
                                    </label>
                                    <label class="upload-img-3 m-0">
                                        <div class="img">
                                            <img src=""
                                                onerror='this.src="{{ asset('/public/assets/admin/img/aspect-1.png') }}"'
                                                alt="" class="img__aspect-1 min-w-187px max-w-187px">
                                        </div>
                                        <input type="file" name="image" hidden>
                                    </label>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-3">
                                <button type="reset" class="btn btn--reset">{{ translate('Reset') }}</button>
                                <button type="submit" class="btn btn--primary mb-2">{{ translate('Add') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                @php($features = \App\Models\AdminFeature::all())
                <div class="card">
                    <div class="card-header py-2">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">{{ translate('Features_List') }}
                                {{-- <span class="badge badge-secondary ml-1">5</span>  --}}
                            </h5>
                            {{-- <form action="javascript:" id="search-form" class="search-form">
                                        <!-- Search -->
                            @csrf
                            <div class="input-group input--group">
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="{{translate('Search by ID or name')}}" aria-label="{{translate('messages.search')}}" required>
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
            
                            </div>
                            <!-- End Search -->
                        </form> --}}
                            <!-- Unfold -->
                            {{-- <div class="hs-unfold mr-2">
                            <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                                data-hs-unfold-options='{
                                        "target": "#usersExportDropdown",
                                        "type": "css-animation"
                                    }'>
                                <i class="tio-download-to mr-1"></i> {{ translate('messages.export') }}
                            </a>
            
                            <div id="usersExportDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                <span class="dropdown-header">{{ translate('messages.download') }}
                                    {{ translate('messages.options') }}</span>
                                <a id="export-excel" class="dropdown-item" href="{{route('admin.store.export', ['type'=>'excel',request()->getQueryString()])}}">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="{{ asset('public/assets/admin') }}/svg/components/excel.svg"
                                        alt="Image Description">
                                    {{ translate('messages.excel') }}
                                </a>
                                <a id="export-csv" class="dropdown-item" href="{{route('admin.store.export', ['type'=>'csv',request()->getQueryString()])}}">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="{{ asset('public/assets/admin') }}/svg/components/placeholder-csv-format.svg"
                                        alt="Image Description">
                                    .{{ translate('messages.csv') }}
                                </a>
                            </div>
                        </div> --}}
                            <!-- End Unfold -->
                        </div>
                    </div>
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
                                        <th class="border-0">{{ translate('sl') }}</th>
                                        <th class="border-0">{{ translate('Title') }}</th>
                                        <th class="border-0">{{ translate('Sub Title') }}</th>
                                        <th class="border-0">{{ translate('Image') }}</th>
                                        <th class="border-0">{{ translate('Status') }}</th>
                                        <th class="text-center border-0">{{ translate('messages.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($features as $key => $feature)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <div class="text--title">
                                                    {{ $feature->title }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="d-block font-size-sm text-body">
                                                    {{ $feature->sub_title }}
                        </div>
                        </td>
                        <td>
                            <img src="{{ asset('storage/app/public/admin_feature') }}/{{ $feature->image }}"
                                onerror="this.src='{{ asset('/public/assets/admin/img/upload-3.png') }}'"
                                class="__size-105" alt="">
                        </td>
                        <td>
                            <label class="toggle-switch toggle-switch-sm">
                                <input type="checkbox" class="toggle-switch-input"
                                    onclick="toogleStatusModal(event,'status-{{ $feature->id }}','feature-list-on.png','feature-list-off.png','{{ translate('By Turning ON ') }} <strong>{{ translate('Feature List Section') }}','{{ translate('By Turning OFF ') }} <strong>{{ translate('Feature List Section') }}',`<p>{{ translate('Feature list is enabled. You can now access its features and functionality') }}</p>`,`<p>{{ translate('Feature list will be disabled. You can enable it in the settings to access its features and functionality') }}</p>`)"
                                    id="status-{{ $feature->id }}" {{ $feature->status ? 'checked' : '' }}>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                            <form
                                action="{{ route('admin.business-settings.feature-status', [$feature->id, $feature->status ? 0 : 1]) }}"
                                method="get" id="status-{{ $feature->id }}_form">
                            </form>
                        </td>

                        <td>
                            <div class="btn--container justify-content-center">
                                <a class="btn action-btn btn--primary btn-outline-primary"
                                    href="{{ route('admin.business-settings.feature-edit', [$feature['id']]) }}">
                                    <i class="tio-edit"></i>
                                </a>
                                <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                    onclick="form_alert('banner-{{ $feature['id'] }}','{{ translate('Want to delete this banner ?') }}')"
                                    title="{{ translate('messages.delete') }} {{ translate('messages.banner') }}"><i
                                        class="tio-delete-outlined"></i>
                                </a>
                                <form action="{{ route('admin.business-settings.feature-delete', [$feature['id']]) }}"
                                    method="post" id="banner-{{ $feature['id'] }}">
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
                @if (count($features) === 0)
                    <div class="empty--data">
                        <img src="{{ asset('/public/assets/admin/svg/illustrations/sorry.svg') }}" alt="public">
                        <h5>
                            {{ translate('no_data_found') }}
                        </h5>
                    </div>
                @endif
            </div>

            <!-- Criteria Modal -->
            <div class="modal fade" id="feature-modal">
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
                                        <img src="{{ asset('/public/assets/admin/img/modal/feature-list-off.png') }}"
                                            alt="" class="mb-20">
                                        <h5 class="modal-title">{{ translate('By Turning OFF ') }}
                                            <strong>{{ translate('Feature List Section') }}</strong></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            {{ translate('Feature list will be disabled. You can enable it in the settings to access its features and functionality') }}
                                        </p>
                                    </div>
                                </div>
                                <!-- <div>
                                        <div class="text-center">
                                            <img src="{{ asset('/public/assets/admin/img/modal/feature-list-on.png') }}" alt="" class="mb-20">
                                            <h5 class="modal-title">{{ translate('By Turning ON ') }} <strong>{{ translate('Feature List Section') }}</strong></h5>
                                        </div>
                                        <div class="text-center">
                                            <p>
                                                {{ translate('Feature list is enabled. You can now access its features and functionality') }}
                                            </p>
                                        </div>
                                    </div> -->
                                <div class="btn--container justify-content-center">
                                    <button type="submit" class="btn btn--primary min-w-120"
                                        data-dismiss="modal">{{ translate('Ok') }}</button>
                                    <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120"
                                        data-dismiss="modal">
                                        {{ translate('Cancel') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Module Setup Section View -->
            <div class="modal fade" id="admin-feature-sectin-view">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3">{{ translate('Feature List') }}</h3>
                            </div>
                            <img src="{{ asset('/public/assets/admin/img/zone-instruction.png') }}" alt="admin/img"
                                class="w-100">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <!-- How it Works -->
    <div class="modal fade" id="how-it-works">
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
                            <div class="max-349 mx-auto mb-20 text-center">
                                <img src="{{ asset('/public/assets/admin/img/landing-how.png') }}" alt=""
                                    class="mb-20">
                                <h5 class="modal-title">{{ translate('Notice!') }}</h5>
                                <p>
                                    {{ translate('If you want to disable or turn off any section please leave that section empty, don’t make any changes there!') }}
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="max-349 mx-auto mb-20 text-center">
                                <img src="{{ asset('/public/assets/admin/img/notice-2.png') }}" alt=""
                                    class="mb-20">
                                <h5 class="modal-title">{{ translate('If You Want to Change Language') }}</h5>
                                <p>
                                    {{ translate('Change the language on tab bar and input your data again!') }}
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="max-349 mx-auto mb-20 text-center">
                                <img src="{{ asset('/public/assets/admin/img/notice-3.png') }}" alt=""
                                    class="mb-20">
                                <h5 class="modal-title">{{ translate('Let’s See The Changes!') }}</h5>
                                <p>
                                    {{ translate('Visit landing page to see the changes you made in the settings option!') }}
                                </p>
                                <div class="btn-wrap">
                                    <button type="submit" class="btn btn--primary w-100" data-dismiss="modal">Visit
                                        Now</button>
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
        $(".lang_link").click(function(e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);

            console.log(lang);

            $("#" + lang + "-form").removeClass('d-none');
            $("#" + lang + "-form1").removeClass('d-none');
            if (lang == '{{ $default_lang }}') {
                $(".from_part_2").removeClass('d-none');
            }
            if (lang == 'default') {
                $(".default-form").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
@endpush
