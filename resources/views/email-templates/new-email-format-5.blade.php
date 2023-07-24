<!DOCTYPE html>
<?php
    $lang = \App\CentralLogics\Helpers::system_default_language();
    $site_direction = \App\CentralLogics\Helpers::system_default_direction();
?>
<html lang="{{ $lang }}" class="{{ $site_direction === 'rtl'?'active':'' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            background: #f7fbff;
            color: #334257;
            font-size: 13px;
            line-height: 1.5;
            display: flex;align-items: center;justify-content: center;
            min-height: 100vh;

        }

        table {
            border-collapse: collapse !important;
        }
        .border-top {
            border-top: 1px solid rgba(0, 170, 109, 0.3);
            padding: 15px 0 10px;
            display: block;
        }
        .d-block {
            display: block;
        }
        .privacy {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }
        .privacy a {
            text-decoration: none;
            color: #334257;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }
        .privacy a span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #334257;
            display: inline-block;
            margin: 0 7px;
        }
        .social {
            margin: 15px 0 8px;
            display: block;
        }
        .copyright{
            text-align: center;
            display: block;
        }
        .text-base {
            color: var(--base);
font-weight: 700
        }

        .mail-img-1 {
            width: 140px;
            height: 60px;
            object-fit: contain
        }
        .mail-img-2 {
            width: 130px;
            height: 45px;
            object-fit: contain
        }
        .mail-img-3 {
            width: 100%;
            height: 172px;
            object-fit: cover
        }
.social img {
width: 24px;    
}
    </style>
</head>

<body style="background-color: #e9ecef;padding:15px">
    <table dir="{{ $site_direction }}" style="width:100%;max-width:500px;margin:0 auto;text-align:center;background:#fff">
        <tr>
            <td style="padding:30px 30px 0">
                <img class="mail-img-2"
                @if ($data && $data['icon'])
                src="{{ asset('storage/app/public/email_template/') }}/{{ $data['icon']??'' }}"
                @else
                src='{{ asset('/public/assets/admin/img/email-template-img.png') }}'
                @endif
                id="iconViewer" alt="">
                <h3 style="font-size:17px;font-weight:500" class="mt-2" id="mail-title">{{ $title?? translate('Main_Title_or_Subject_of_the_Mail') }}</h3>

            </td>
        </tr>
        <tr>
            <td style="padding:0 30px 30px; text-align:start">
                <span style="font-weight:500;display:block;margin: 20px 0 11px;" id="mail-body">{!! $body??'Please click the link below to change your password' !!}</span>
                {{-- <span style="display:block;margin-bottom:14px">
                    Please click <a href="" style="font-weight:500;color:#0177CD">Here</a>  or click the link below to change your password
                </span> --}}
                @if (isset($url))
                <span style="display:block;margin-bottom:14px">
                    {{-- <span style="display:block" id="mail-button">{{ $data['button_name']??'Click Here' }}</span> --}}
                    <a href="{{ $url }}" style="color: #0177CD">{{ $url }}</a>
                </span>
                @endif
                @if ($data?->button_url)
                    <span class="d-block text-center" style="margin-top: 16px">
                    <a href="{{ $data['button_url']??'#' }}" class="cmn-btn" id="mail-button">{{ $data['button_name']??'Submit' }}</a>
                    </span>
                    @endif
                <span class="border-top"></span>
                <span class="d-block" style="margin-bottom:14px" id="mail-footer">{{ $data['footer_text'] ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.') }}</span>
                <span class="d-block">{{ translate('Thanks & Regards') }},</span>
                <span class="d-block" style="margin-bottom:20px">{{ $company_name }}</span>

                @if ($data?->logo)
                <img style="width:100px;display:block;margin:10px auto" src="{{ asset('storage/app/public/email_template/') }}/{{ $data['logo']??'' }}" alt="public/img">
                @else
                @php($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()->value)
                <img style="width:100px;display:block;margin:10px auto" src='{{ asset('storage/app/public/business/' . $store_logo) }}'alt="public/img">
                @endif
                <span class="privacy">
                    @php($landing_data =\App\Models\DataSetting::where('type', 'admin_landing_page')->whereIn('key', ['shipping_policy_status','refund_policy_status','cancellation_policy_status'])->pluck('value','key')->toArray())
                    <a href="{{ route('privacy-policy') }}" id="privacy-check" style="{{ (isset($data['privacy']) && $data['privacy'] == 1)?'':'display:none;' }}">{{ translate('Privacy_Policy')}}</a>
                    @if (isset($landing_data['refund_policy_status']) && $landing_data['refund_policy_status']  == 1)
                    <a href="{{ route('refund') }}" id="refund-check" style="{{ (isset($data['refund']) && $data['refund'] == 1)?'':'display:none;' }}"><span class="dot"></span>{{ translate('Refund_Policy') }}</a>
                    @endif
                    @if (isset($landing_data['cancellation_policy_status']) && $landing_data['cancellation_policy_status']  == 1)
                    <a href="{{ route('cancelation') }}" id="cancelation-check" style="{{ (isset($data['cancelation']) && $data['cancelation'] == 1)?'':'display:none;' }}"><span class="dot"></span>{{ translate('Cancelation_Policy') }}</a>
                    @endif
                    <a href="{{ route('contact-us') }}" id="contact-check" style="{{ (isset($data['contact']) && $data['contact'] == 1)?'':'display:none;' }}"><span class="dot"></span>{{ translate('Contact_us') }}</a>
                </span>
                <span class="social" style="text-align:center">
                    @php($social_media = \App\Models\SocialMedia::active()->get())
                    @if (isset($social_media))
                        @foreach ($social_media as $social)
                            <a href="{{ $social->link }}" target=”_blank” id="{{ $social->name  }}-check" style="margin: 0 5px;text-decoration:none;{{ (isset($data[$social->name]) && $data[$social->name] == 1)?'':'display:none;' }}">
                                <img src="{{asset('/public/assets/admin/img/img/')}}/{{ $social->name }}.png" alt="">
                            </a>
                        @endforeach
                    @endif
                </span>
                <span class="copyright" id="mail-copyright">
                    {{ $copyright_text?? translate('Copyright 2023 6ammart. All right reserved') }}
                </span>
            </td>
        </tr>
    </table>
</body>

</html>
