@extends('layouts.admin.app')

@section('title', translate('Edit item'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    @php($opening_time = '')
    @php($closing_time = '')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-flex flex-wrap __gap-15px justify-content-between align-items-center">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{ asset('public/assets/admin/img/edit.png') }}" class="w--22" alt="">
                </span>
                <span>
                    {{ translate('messages.item_update') }}
                </span>
            </h1>
            <div class="d-flex align-items-end">
                @if(Config::get('module.current_module_type') == 'food')
                <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" onclick="foodModalShow()" >
                    <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                    <div>
                        <i class="tio-info-outined"></i>
                    </div>
                </div>
                @else
                <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" onclick="attributeModalShow()" >
                    <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                    <div>
                        <i class="tio-info-outined"></i>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- End Page Header -->
        <form action="javascript:" method="post" id="product_form" enctype="multipart/form-data">
            @csrf
            @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
            @php($language = $language->value ?? null)
            @php($default_lang = str_replace('_', '-', app()->getLocale()))
            <div class="row g-2">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            @if ($language)
                                <ul class="nav nav-tabs border-0 mb-3">
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
                            @if ($language)
                                <div class="lang_form" id="default-form">
                                    <div class="form-group">
                                        <label class="input-label" for="default_name">{{ translate('messages.name') }}
                                            ({{ translate('messages.default') }})</label>
                                        <input type="text" name="name[]" id="default_name" class="form-control"
                                            placeholder="{{ translate('messages.new_food') }}"
                                            value="{{ $product?->getRawOriginal('name') }}" required
                                            oninvalid="document.getElementById('en-link').click()">
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    <div class="form-group pt-2 mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.short') }}
                                            {{ translate('messages.description') }}
                                            ({{ translate('messages.default') }})</label>
                                        <textarea type="text" name="description[]" class="form-control ckeditor min--height-200">{!! $product?->getRawOriginal('description') !!}</textarea>
                                    </div>
                                </div>
                                @foreach (json_decode($language) as $lang)
                                    <?php
                                    if (count($product['translations'])) {
                                        $translate = [];
                                        foreach ($product['translations'] as $t) {
                                            if ($t->locale == $lang && $t->key == 'name') {
                                                $translate[$lang]['name'] = $t->value;
                                            }
                                            if ($t->locale == $lang && $t->key == 'description') {
                                                $translate[$lang]['description'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="d-none lang_form" id="{{ $lang }}-form">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="{{ $lang }}_name">{{ translate('messages.name') }}
                                                ({{ strtoupper($lang) }})</label>
                                            <input type="text" name="name[]" id="{{ $lang }}_name"
                                                class="form-control" placeholder="{{ translate('messages.new_food') }}"
                                                value="{{ $translate[$lang]['name'] ?? '' }}"
                                                oninvalid="document.getElementById('en-link').click()">
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{ $lang }}">
                                        <div class="form-group pt-2 mb-0">
                                            <label class="input-label"
                                                for="exampleFormControlInput1">{{ translate('messages.short') }}
                                                {{ translate('messages.description') }} ({{ strtoupper($lang) }})</label>
                                            <textarea type="text" name="description[]" class="form-control ckeditor min--height-200">{!! $translate[$lang]['description'] ?? '' !!}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div id="default-form">
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.name') }}
                                            ({{ translate('messages.default') }})</label>
                                        <input type="text" name="name[]" class="form-control"
                                            placeholder="{{ translate('messages.new_food') }}"
                                            value="{{ $product['name'] }}" required>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    <div class="form-group pt-2 mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.short') }}
                                            {{ translate('messages.description') }}</label>
                                        <textarea type="text" name="description[]" class="form-control ckeditor min--height-200">{!! $product['description'] !!}</textarea>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-wrap align-items-center">
                            <div class="w-100 d-flex flex-wrap __gap-15px">
                                <div class="flex-grow-1 mx-auto">
                                    <label class="text-dark d-block">
                                        {{ translate('messages.item_image') }}
                                        <small class="text-danger">* ( {{ translate('messages.ratio') }} 1:1 )</small>
                                    </label>
                                    <div class="d-flex flex-wrap __gap-12px __new-coba" id="coba">
                                        @foreach ($product->images as $key => $photo)
                                            <div class="spartan_item_wrapper min-w-100px max-w-100px">
                                                <img class="img--square"
                                                    src="{{ asset("storage/app/public/product/$photo") }}"
                                                    alt="Product image">
                                                <a href="{{ route('admin.item.remove-image', ['id' => $product['id'], 'name' => $photo]) }}"
                                                    class="spartan_remove_row"><i class="tio-add-to-trash"></i></a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex-grow-1 mx-auto">
                                    <label class="text-dark d-block">
                                        {{ translate('messages.item') }} {{ translate('messages.thumbnail') }}
                                        <small class="text-danger">* ( {{ translate('messages.ratio') }} 1:1 )</small>
                                    </label>
                                    <label class="d-inline-block m-0">
                                        <img class="img--100" id="viewer"
                                            src="{{ asset('storage/app/public/product') }}/{{ $product['image'] }}"
                                            onerror="this.src='{{ asset('public/assets/admin/img/upload.png') }}'"
                                            alt="thumbnail" />
                                        <input type="file" name="image" id="customFileEg1"
                                            class="custom-file-input d-none"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-dashboard-outlined"></i>
                                </span>
                                <span> {{ translate('item_details') }} </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="store_id">{{ translate('messages.store') }}<span
                                                class="input-label-secondary"></span></label>
                                        <select name="store_id"
                                            data-placeholder="{{ translate('messages.select') }} {{ translate('messages.store') }}"
                                            id="store_id" class="js-data-example-ajax form-control"
                                            onchange="getStoreData('{{ url('/') }}/admin/store/get-addons?data[]=0&store_id=', this.value,'add_on')"
                                            title="Select Store" required
                                            oninvalid="this.setCustomValidity('{{ translate('messages.please_select_store') }}')">
                                            @if (isset($product->store))
                                                <option value="{{ $product->store_id }}" selected="selected">
                                                    {{ $product->store->name }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="category_id">{{ translate('messages.category') }}<span
                                                class="input-label-secondary">*</span></label>
                                        <select name="category_id" class="js-data-example-ajax form-control"
                                            id="category_id" onchange="categoryChange(this.value)">
                                            @if ($category)
                                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1">{{ translate('messages.sub_category') }}<span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ translate('messages.category_required_warning') }}"><img
                                                    src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ translate('messages.category_required_warning') }}"></span></label>
                                        <select name="sub_category_id" class="js-data-example-ajax form-control"
                                            id="sub-categories">
                                            @if (isset($sub_category))
                                                <option value="{{ $sub_category['id'] }}">{{ $sub_category['name'] }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="unit_input">
                                    <div class="form-group mb-0">
                                        <label class="input-label text-capitalize"
                                            for="unit">{{ translate('messages.unit') }}</label>
                                        <select name="unit" class="form-control js-select2-custom">
                                            @foreach (\App\Models\Unit::all() as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ $unit->id == $product->unit_id ? 'selected' : '' }}>
                                                    {{ $unit->unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="veg_input">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.item_type') }}</label>
                                        <select name="veg" class="form-control js-select2-custom">
                                            <option value="0" {{ $product['veg'] == 0 ? 'selected' : '' }}>
                                                {{ translate('messages.non_veg') }}</option>
                                            <option value="1" {{ $product['veg'] == 1 ? 'selected' : '' }}>
                                                {{ translate('messages.veg') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="stock_input">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="total_stock">{{ translate('messages.total_stock') }}</label>
                                        <input type="number" class="form-control" name="current_stock"
                                            value="{{ $product->stock }}" id="quantity">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="organic">
                                    <div class="form-check mb-0 p-6">
                                        <input class="form-check-input" name="organic" type="checkbox" value="1" id="flexCheckDefault" {{ $product->organic == 1?'checked':'' }}>
                                        <label class="form-check-label" for="flexCheckDefault">
                                          {{ translate('messages.is_organic') }}
                                        </label>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" id="addon_input">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-dashboard-outlined"></i></span>
                                <span>{{ translate('messages.addon') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label class="input-label"
                                    for="exampleFormControlSelect1">{{ translate('messages.addon') }}<span
                                        class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                        data-original-title="{{ translate('messages.store_required_warning') }}"><img
                                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                            alt="{{ translate('messages.store_required_warning') }}"></span></label>
                                <select name="addon_ids[]" class="form-control js-select2-custom" multiple="multiple"
                                    id="add_on">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" id="time_input">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-date-range"></i></span>
                                <span>{{ translate('time_schedule') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.available') }}
                                            {{ translate('messages.time') }} {{ translate('messages.starts') }}</label>
                                        <input type="time" value="{{ $product['available_time_starts'] }}"
                                            name="available_time_starts" class="form-control" id="available_time_starts"
                                            placeholder="{{ translate('messages.Ex:') }} 10:30 am">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.available') }}
                                            {{ translate('messages.time') }} {{ translate('messages.ends') }}</label>
                                        <input type="time" value="{{ $product['available_time_ends'] }}"
                                            name="available_time_ends" class="form-control" id="available_time_ends"
                                            placeholder="5:45 pm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-dollar-outlined"></i></span>
                                <span>{{ translate('amount') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.price') }}</label>
                                        <input type="number" value="{{ $product['price'] }}" min="0"
                                            max="999999999999.99" name="price" class="form-control" step="0.01"
                                            placeholder="{{ translate('messages.Ex:') }} 100" required>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.discount') }}
                                            {{ translate('messages.type') }}<span
                                                class="input-label-secondary text--title" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="{{ translate('Currently you need to manage discount with store.') }}">
                                                <i class="tio-info-outined"></i>
                                            </span></label>
                                        <select name="discount_type" class="form-control js-select2-custom">
                                            <option value="percent"
                                                {{ $product['discount_type'] == 'percent' ? 'selected' : '' }}>
                                                {{ translate('messages.percent') }}
                                            </option>
                                            <option value="amount"
                                                {{ $product['discount_type'] == 'amount' ? 'selected' : '' }}>
                                                {{ translate('messages.amount') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.discount') }}</label>
                                        <input type="number" min="0" value="{{ $product['discount'] }}"
                                            max="100000" name="discount" class="form-control"
                                            placeholder="{{ translate('messages.Ex:') }} 100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" id="food_variation_section">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header flex-wrap">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-canvas-text"></i>
                                </span>
                                <span>{{ translate('messages.food_variations') }}</span>
                            </h5>
                            <a class="btn text--primary-2" id="add_new_option_button">
                                {{ translate('add_new_variation') }}
                                <i class="tio-add"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div id="add_new_option">
                                @if (isset($product->food_variations) && count(json_decode($product->food_variations,true))>0)
                                    @foreach (json_decode($product->food_variations, true) as $key_choice_options => $item)
                                        @if (isset($item['price']))
                                        @break

                                    @else
                                        @include('admin-views.product.partials._new_variations', [
                                            'item' => $item,
                                            'key' => $key_choice_options + 1,
                                        ])
                                    @endif
                                    @endforeach
                                @endif
                            </div>
                            
                                <!-- Empty Variation -->
                                @if (!isset($product->food_variations) || count(json_decode($product->food_variations,true))<1)
                                <div id="empty-variation">
                                    <div class="text-center">
                                        <img src="{{ asset('/public/assets/admin/img/variation.png') }}" alt="">
                                        <div>{{ translate('No variation added') }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
            <div class="col-md-12" id="attribute_section">
                <div class="card shadow--card-2 border-0">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon"><i class="tio-canvas-text"></i></span>
                            <span>{{ translate('attribute') }}</span>
                        </h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="exampleFormControlSelect1">{{ translate('messages.attribute') }}<span
                                            class="input-label-secondary"></span></label>
                                    <select name="attribute_id[]" id="choice_attributes"
                                        class="form-control js-select2-custom" multiple="multiple">
                                        @foreach (\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                            <option value="{{ $attribute['id'] }}"
                                                {{ in_array($attribute->id, json_decode($product['attributes'], true)) ? 'selected' : '' }}>
                                                {{ $attribute['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <div class="customer_choice_options d-flex __gap-24px"
                                        id="customer_choice_options">
                                        @include('admin-views.product.partials._choices', [
                                            'choice_no' => json_decode($product['attributes']),
                                            'choice_options' => json_decode($product['choice_options'], true),
                                        ])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="variant_combination" id="variant_combination">
                                    @include('admin-views.product.partials._edit-combinations', [
                                        'combinations' => json_decode($product['variations'], true),
                                        'stock' => config('module.' . $product->module->module_type)['stock'],
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card shadow--card-2 border-0">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon"><i class="tio-label"></i></span>
                            <span>{{ translate('tags') }}</span>
                        </h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="tags"
                                        placeholder="Enter tags"
                                        value="@foreach ($product->tags as $c) {{ $c->tag . ',' }} @endforeach"
                                        data-role="tagsinput">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="btn--container justify-content-end">
                    <button type="reset" id="reset_btn"
                        class="btn btn--reset">{{ translate('messages.reset') }}</button>
                    <button type="submit" class="btn btn--primary">{{ translate('messages.submit') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="food-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" onclick="foodModalClose()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/xG8fO7TXPbk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                  </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="attribute-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" onclick="attributeModalClose()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/xG8fO7TXPbk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                  </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script_2')
<script>
    function show_min_max(data) {
        console.log(data);
        $('#min_max1_' + data).removeAttr("readonly");
        $('#min_max2_' + data).removeAttr("readonly");
        $('#min_max1_' + data).attr("required", "true");
        $('#min_max2_' + data).attr("required", "true");
    }

    function hide_min_max(data) {
        console.log(data);
        $('#min_max1_' + data).val(null).trigger('change');
        $('#min_max2_' + data).val(null).trigger('change');
        $('#min_max1_' + data).attr("readonly", "true");
        $('#min_max2_' + data).attr("readonly", "true");
        $('#min_max1_' + data).attr("required", "false");
        $('#min_max2_' + data).attr("required", "false");
    }
    var count = {{ isset($product->food_variations) ? count(json_decode($product->food_variations, true)) : 0 }};

    $(document).ready(function() {

        // $('#organic').hide();
        $("#add_new_option_button").click(function(e) {
            $('#empty-variation').hide();
            count++;
            var add_option_view = `
                    <div class="__bg-F8F9FC-card view_new_option mb-2">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-check form--check">
                                    <input id="options[` + count + `][required]" name="options[` + count + `][required]" class="form-check-input" type="checkbox">
                                    <span class="form-check-label">{{ translate('Required') }}</span>
                                </label>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm delete_input_button" onclick="removeOption(this)"
                                        title="{{ translate('Delete') }}">
                                        <i class="tio-add-to-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-xl-4 col-lg-6">
                                    <label for="">{{ translate('name') }}</label>
                                    <input required name=options[` + count +
                `][name] class="form-control" type="text" onkeyup="new_option_name(this.value,` +
                count + `)">
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label class="input-label text-capitalize d-flex align-items-center"><span class="line--limit-1">{{ translate('messages.selcetion_type') }} </span>
                                        </label>
                                        <div class="resturant-type-group px-0">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="multi"
                                                name="options[` + count + `][type]" id="type` + count +
                `" checked onchange="show_min_max(` + count + `)"
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Multiple Selection') }}
                                                </span>
                                            </label>

                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="single"
                                                name="options[` + count + `][type]" id="type` + count +
                `" onchange="hide_min_max(` + count + `)"
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Single Selection') }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label for="">{{ translate('Min') }}</label>
                                            <input id="min_max1_` + count + `" required  name="options[` + count + `][min]" class="form-control" type="number" min="1">
                                        </div>
                                        <div class="col-6">
                                            <label for="">{{ translate('Max') }}</label>
                                            <input id="min_max2_` + count + `"   required name="options[` + count + `][max]" class="form-control" type="number" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="option_price_` + count + `" >
                                <div class="bg-white border rounded p-3 pb-0 mt-3">
                                    <div  id="option_price_view_` + count + `">
                                        <div class="row g-3 add_new_view_row_class mb-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Option_name') }}</label>
                                                <input class="form-control" required type="text" name="options[` +
                count +
                `][values][0][label]" id="">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Additional_price') }}</label>
                                                <input class="form-control" required type="number" min="0" step="0.01" name="options[` +
                count + `][values][0][optionPrice]" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 p-3 mr-1 d-flex "  id="add_new_button_` + count +
                `">
                                        <button type="button" class="btn btn--primary btn-outline-primary" onclick="add_new_row_button(` +
                count + `)" >{{ translate('Add_New_Option') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

            $("#add_new_option").append(add_option_view);
        });
    });

    function new_option_name(value, data) {
        $("#new_option_name_" + data).empty();
        $("#new_option_name_" + data).text(value)
        console.log(value);
    }

    function removeOption(e) {
        element = $(e);
        element.parents('.view_new_option').remove();
    }

    function deleteRow(e) {
        element = $(e);
        element.parents('.add_new_view_row_class').remove();
    }


    function add_new_row_button(data) {
        count = data;
        countRow = 1 + $('#option_price_view_' + data).children('.add_new_view_row_class').length;
        var add_new_row_view = `
            <div class="row add_new_view_row_class mb-3 position-relative pt-3 pt-sm-0">
                <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Option_name') }}</label>
                        <input class="form-control" required type="text" name="options[` + count + `][values][` +
            countRow + `][label]" id="">
                    </div>
                    <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Additional_price') }}</label>
                        <input class="form-control"  required type="number" min="0" step="0.01" name="options[` +
            count +
            `][values][` + countRow + `][optionPrice]" id="">
                    </div>
                    <div class="col-sm-2 max-sm-absolute">
                        <label class="d-none d-sm-block">&nbsp;</label>
                        <div class="mt-1">
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)"
                                title="{{ translate('Delete') }}">
                                <i class="tio-add-to-trash"></i>
                            </button>
                        </div>
                </div>
            </div>`;
        $('#option_price_view_' + data).append(add_new_row_view);

    }
</script>
<script src="{{ asset('public/assets/admin') }}/js/tags-input.min.js"></script>
<script>
    function getStoreData(route, store_id, id) {
        $.get({
            url: route + store_id,
            dataType: 'json',
            success: function(data) {
                $('#' + id).empty().append(data.options);
            },
        });
    }

    function getRequest(route, id) {
        $.get({
            url: route,
            dataType: 'json',
            success: function(data) {
                $('#' + id).empty().append(data.options);
            },
        });
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#viewer').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#customFileEg1").change(function() {
        readURL(this);
        $('#image-viewer-section').show(1000)
    });

    $(document).ready(function() {
        @if (count(json_decode($product['add_ons'], true)) > 0)
            getStoreData(
                '{{ url('/') }}/admin/store/get-addons?@foreach (json_decode($product['add_ons'], true) as $addon)data[]={{ $addon }}& @endforeach store_id=',
                '{{ $product['store_id'] }}', 'add_on');
        @else
            getStoreData('{{ url('/') }}/admin/store/get-addons?data[]=0&store_id=',
                '{{ $product['store_id'] }}', 'add_on');
        @endif
    });
</script>

<script>
    var module_id = {{ $product->module_id }};
    var module_type = "{{ $product->module->module_type }}";
    console.log(module_type);
    if (module_type == 'food') {
        $('#food_variation_section').show();
        $('#attribute_section').hide();
    } else {
        $('#food_variation_section').hide();
        $('#attribute_section').show();
    }
    if (module_type == 'grocery') {
        $('#organic').show();
    }else{
        $('#organic').hide();

    }
    var parent_category_id = {{ $category ? $category->id : 0 }};
    <?php
    $module_data = config('module.' . $product->module->module_type);
    unset($module_data['description']);
    ?>
    var module_data = {{ str_replace('"', '', json_encode($module_data)) }};
    var stock = {{ $product->module->module_type == 'food' ? 'false' : 'true' }};
    input_field_visibility_update();

    function modulChange(id) {
        $.get({
            url: "{{ url('/') }}/admin/module/" + id,
            dataType: 'json',
            success: function(data) {
                module_data = data.data;
                stock = module_data.stock;
                input_field_visibility_update();
                combination_update();
            },
        });
        module_id = id;
    }

    function input_field_visibility_update() {
        if (module_data.stock) {
            $('#stock_input').show();
        } else {
            $('#stock_input').hide();
        }
        if (module_data.add_on) {
            $('#addon_input').show();
        } else {
            $('#addon_input').hide();
        }

        if (module_data.item_available_time) {
            $('#time_input').show();
        } else {
            $('#time_input').hide();
        }

        if (module_data.veg_non_veg) {
            $('#veg_input').show();
        } else {
            $('#veg_input').hide();
        }

        if (module_data.unit) {
            $('#unit_input').show();
        } else {
            $('#unit_input').hide();
        }
    }

    function categoryChange(id) {
        parent_category_id = id;
        console.log(parent_category_id);
    }

    function foodModalClose() {
        $('#food-modal').hide();

    }
    function foodModalShow() {
        $('#food-modal').show();
    }
    function attributeModalClose() {
        $('#attribute-modal').hide();

    }
    function attributeModalShow() {
        $('#attribute-modal').show();
    }

    $(document).on('ready', function() {
        $('.js-select2-custom').each(function() {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });
    });

    $('#store_id').select2({
        ajax: {
            url: '{{ url('/') }}/admin/store/get-stores',
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                    module_id: module_id
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            __port: function(params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#category_id').select2({
        ajax: {
            url: '{{ url('/') }}/admin/item/get-categories?parent_id=0',
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                    module_id: module_id
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            __port: function(params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#sub-categories').select2({
        ajax: {
            url: '{{ url('/') }}/admin/item/get-categories',
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                    module_id: module_id,
                    parent_id: parent_category_id,
                    sub_category: true
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            __port: function(params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#choice_attributes').on('change', function() {
        $('#customer_choice_options').html(null);
        combination_update();
        $.each($("#choice_attributes option:selected"), function() {
            add_more_customer_choice_option($(this).val(), $(this).text());
        });
    });

    function add_more_customer_choice_option(i, name) {
        let n = name;

        $('#customer_choice_options').append(
            `<div class="__choos-item"><div><input type="hidden" name="choice_no[]" value="${i}"><input type="text" class="form-control d-none" name="choice[]" value="${n}" placeholder="{{ translate('messages.choice_title') }}" readonly> <label class="form-label">${n}</label> </div><div><input type="text" class="form-control" name="choice_options_${i}[]" placeholder="{{ translate('messages.enter_choice_values') }}" data-role="tagsinput" onchange="combination_update()"></div></div>`
        );
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
    }

    setTimeout(function() {
        $('.call-update-sku').on('change', function() {
            combination_update();
        });
    }, 2000)

    $('#colors-selector').on('change', function() {
        combination_update();
    });

    $('input[name="unit_price"]').on('keyup', function() {
        combination_update();
    });

    function combination_update() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('admin.item.variant-combination') }}",
            data: $('#product_form').serialize() + '&stock=' + stock,
            beforeSend: function() {
                $('#loading').show();
            },
            success: function(data) {
                $('#loading').hide();
                $('#variant_combination').html(data.view);
                if (data.length < 1) {
                    $('input[name="current_stock"]').attr("readonly", false);
                }
            }
        });
    }
</script>

<!-- submit form -->
<script>
    $('#product_form').on('submit', function() {
        console.log('working');
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: '{{ route('admin.item.update', [$product['id']]) }}',
            data: $('#product_form').serialize(),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#loading').show();
            },
            success: function(data) {
                console.log(data);
                $('#loading').hide();
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    toastr.success('{{ translate('messages.product_updated_successfully') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    setTimeout(function() {
                        location.href =
                            '{{ \Request::server('HTTP_REFERER') ?? route('admin.item.list') }}';
                    }, 2000);
                }
            }
        });
    });
</script>
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
        if (lang == 'en') {
            $("#from_part_2").removeClass('d-none');
        } else {
            $("#from_part_2").addClass('d-none');
        }
    })

    $('#reset_btn').click(function() {
        location.reload(true);
    })
</script>
<script>
    update_qty();

    function update_qty() {
        var total_qty = 0;
        var qty_elements = $('input[name^="stock_"]');
        for (var i = 0; i < qty_elements.length; i++) {
            total_qty += parseInt(qty_elements.eq(i).val());
        }
        if (qty_elements.length > 0) {

            $('input[name="current_stock"]').attr("readonly", true);
            $('input[name="current_stock"]').val(total_qty);
        } else {
            $('input[name="current_stock"]').attr("readonly", false);
        }
    }
    $('input[name^="stock_"]').on('keyup', function() {
        var total_qty = 0;
        var qty_elements = $('input[name^="stock_"]');
        for (var i = 0; i < qty_elements.length; i++) {
            total_qty += parseInt(qty_elements.eq(i).val());
        }
        $('input[name="current_stock"]').val(total_qty);
    });
</script>
<script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $("#coba").spartanMultiImagePicker({
            fieldName: 'item_images[]',
            maxCount: 6,
            // rowHeight: '100px !important',
            groupClassName: 'spartan_item_wrapper min-w-100px max-w-100px',
            maxFileSize: '',
            placeholderImage: {
                image: "{{ asset('public/assets/admin/img/upload.png') }}",
                width: '100px'
            },
            dropFileLabel: "Drop Here",
            onAddRow: function(index, file) {

            },
            onRenderedPreview: function(index) {

            },
            onRemoveRow: function(index) {

            },
            onExtensionErr: function(index, file) {
                toastr.error(
                    "{{ translate('messages.please_only_input_png_or_jpg_type_file') }}", {
                        CloseButton: true,
                        ProgressBar: true
                    });
            },
            onSizeErr: function(index, file) {
                toastr.error("{{ translate('messages.file_size_too_big') }}", {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        });
    });
</script>
<script>
    $('#reset_btn').click(function() {
        $('#module_id').val(null).trigger('change');
        $('#store_id').val(null).trigger('change');
        $('#category_id').val(null).trigger('change');
        $('#sub-categories').val(null).trigger('change');
        $('#unit').val(null).trigger('change');
        $('#veg').val(0).trigger('change');
        $('#add_on').val(null).trigger('change');
        $('#discount_type').val(null).trigger('change');
        $('#choice_attributes').val(null).trigger('change');
        $('#customer_choice_options').empty().trigger('change');
        $('#variant_combination').empty().trigger('change');
        $('#time_input').show();
        $('#viewer').hide();
        $("#coba").empty().spartanMultiImagePicker({
            fieldName: 'item_images[]',
            maxCount: 6,
            rowHeight: '100px !important',
            groupClassName: 'spartan_item_wrapper min-w-100px max-w-100px',
            maxFileSize: '',
            placeholderImage: {
                image: "{{ asset('public/assets/admin/img/upload.png') }}",
                width: '100%'
            },
            dropFileLabel: "Drop Here",
            onAddRow: function(index, file) {

            },
            onRenderedPreview: function(index) {

            },
            onRemoveRow: function(index) {

            },
            onExtensionErr: function(index, file) {
                toastr.error(
                    "{{ translate('messages.please_only_input_png_or_jpg_type_file') }}", {
                        CloseButton: true,
                        ProgressBar: true
                    });
            },
            onSizeErr: function(index, file) {
                toastr.error("{{ translate('messages.file_size_too_big') }}", {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        });
    })
</script>
@endpush
