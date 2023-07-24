@extends('layouts.admin.app')

@section('title',translate('messages.terms_and_condition'))

@push('css_or_js')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/privacy-policy.png')}}" class="w--26" alt="">
                </span>
                <span>
                    {{translate('messages.terms_and_condition')}}
                </span>
            </h1>
        </div>

        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.business-settings.terms-and-conditions')}}" method="post" id="terms_and_conditions-form">
                    @csrf

                    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                    @php($language = $language->value ?? null)
                    @php($default_lang = str_replace('_', '-', app()->getLocale()))
                    @if ($language)
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

                    <div class="form-group lang_form" id="default-form">
                        <input type="hidden" name="lang[]" value="default">
                        <textarea class="ckeditor form-control" name="terms_and_conditions[]">{!! $terms_and_conditions?->getRawOriginal('value') ?? '' !!}</textarea>
                    </div>

                    @if ($language)
                        @forelse(json_decode($language) as $lang)
                            <?php
                                if($terms_and_conditions?->translations){
                                    $translate = [];
                                    foreach($terms_and_conditions?->translations as $t)
                                    {
                                        if($t->locale == $lang && $t->key=="terms_and_conditions"){
                                            $translate[$lang]['terms_and_conditions'] = $t->value;
                                        }
                                    }
                                }

                                ?>

                            <div class="form-group d-none lang_form" id="{{$lang}}-form">
                                <textarea class="ckeditor form-control" name="terms_and_conditions[]">{!!  $translate[$lang]['terms_and_conditions'] ?? null !!}</textarea>
                            </div>
                            <input type="hidden" name="lang[]" value="{{$lang}}">
                            @empty
                        @endforelse
                    @endif

                    <div class="btn--container justify-content-end">
                        <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
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
        $("#"+lang+"-form").removeClass('d-none');
    });
</script>
@endpush
