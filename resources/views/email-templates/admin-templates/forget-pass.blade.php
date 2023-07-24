<!DOCTYPE html>
<html>

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
            align-items: center;
            justify-content: center;

        }
        .privacy a {
            text-decoration: none;
            color: #334257;
            position: relative;
        }
        .privacy a:not(:last-child)::after {
            content:'';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #334257;
            display: inline-block;
            margin: 0 15px
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

    </style>
</head>

<body style="background-color: #e9ecef;padding:15px">

    <table style="width:100%;max-width:500px;margin:0 auto;text-align:center;background:#fff">
        <tr>
            <td style="padding:30px 30px 0">
                <img src="{{asset('/public/assets/admin/img/email-template-img.png')}}" alt="">
                <h3 style="font-size:17px;font-weight:500">Change password request</h3>
                
            </td>
        </tr>
        <tr>
            <td style="padding:0 30px 30px; text-align:left">
                <span style="font-weight:500;display:block;margin: 20px 0 11px;">Hi Sabrina,</span>
                <span style="display:block;margin-bottom:14px">
                    Please click <a href="" style="font-weight:500;color:#0177CD">Here</a>  or click the link below to change your password
                </span>
                <span style="display:block;margin-bottom:14px">
                    <span style="display:block">Click here</span>
                    <a href="https://6ammart/changepasswordi357092349-38505320" style="color: #0177CD">https://6ammart/changepasswordi357092349-38505320</a>
                </span>
                <span class="border-top"></span>
                <span class="d-block" style="margin-bottom:14px">Please contact us for any queries, we’re always happy to help. </span>
                <span class="d-block">Thanks & Regards,</span>
                <span class="d-block" style="margin-bottom:20px">6amMart</span>
                @php($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()->value)

                <img style="width:120px;display:block;margin:10px auto" onerror="this.src='{{asset('/public/assets/admin/img/favicon.png')}}'" src="{{ asset('storage/app/public/business/' . $store_logo) }}" alt="public/img">
                <span class="privacy">
                    <a href="">Privacy Policy</a><a href="">Contact Us</a>
                </span>
                <span class="social" style="text-align:center">
                    <a href="" style="margin: 0 5px;text-decoration:none">
                        <img src="{{asset('/public/assets/admin/img/img/pinterest.png')}}" alt="">
                    </a>
                    <a href="" style="margin: 0 5px;text-decoration:none">
                        <img src="{{asset('/public/assets/admin/img/img/instagram.png')}}" alt="">
                    </a>
                    <a href="" style="margin: 0 5px;text-decoration:none">
                        <img src="{{asset('/public/assets/admin/img/img/facebook.png')}}" alt="">
                    </a>
                    <a href="" style="margin: 0 5px;text-decoration:none">
                        <img src="{{asset('/public/assets/admin/img/img/linkedin.png')}}" alt="">
                    </a>
                    <a href="" style="margin: 0 5px;text-decoration:none">
                        <img src="{{asset('/public/assets/admin/img/img/twitter.png')}}" alt="">
                    </a>
                </span>
                <span class="copyright">
                    Copyright 2023 6amMart. All right reserved
                </span>
            </td>
        </tr>
    </table>

</body>

</html>
