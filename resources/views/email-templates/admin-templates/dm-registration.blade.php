<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap');

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            line-height: 21px;
            color: #737883;
            background: #f7fbff;
            padding: 0;
            display: flex;align-items: center;justify-content: center;
            min-height: 100vh;
        }
        h1,h2,h3,h4,h5,h6 {
            color: #334257;
        }
        * {
            box-sizing: border-box
        }

        :root {
            --base: #006161
        }

        .main-table {
            width: 500px;
            background: #FFFFFF;
            margin: 0 auto;
            padding: 40px;
        }
        .main-table-td {
        }
        img {
            max-width: 100%;
        }
        .cmn-btn{
            background: var(--base);
            color: #fff;
            padding: 8px 20px;
            display: inline-block;
            text-decoration: none;
        }
        .mb-1 {
            margin-bottom: 5px;
        }
        .mb-2 {
            margin-bottom: 10px;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
        .mb-4 {
            margin-bottom: 20px;
        }
        .mb-5 {
            margin-bottom: 25px;
        }
        hr {
            border-color : rgba(0, 170, 109, 0.3);
            margin: 16px 0
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
        div {
            display: block;
        }
        a {
            text-decoration: none;
        }
        .text-base {
            color: var(--base);
font-weight: 700
        }
    </style>

</head>


<body>


<table class="main-table">
    <tbody>
        <tr>
            <td class="main-table-td">
                @php($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()->value)
                <img style="width:120px;display:block;margin:10px 0" onerror="this.src='{{asset('/public/assets/admin/img/favicon.png')}}'" src="{{ asset('storage/app/public/business/' . $store_logo) }}" alt="public/img">
                <h2>New Delivery Man Registration Request</h2>
                <div class="mb-1">Hi Admin,</div>
                <div class="mb-4"><strong>John Doe</strong> has requested to join as delivery man in 6amMart platform. </div>
                <div class="mb-2">Review their request from admin panel.</div>
                <img class="mb-2" src="{{asset('/public/assets/admin/img/dm-reg.png')}}" alt="">
                <div class="mb-3">Click on the button below to review the request</div>
                <a href="" class="cmn-btn">See Registration Request</a>
                <hr>
                <div class="mb-2">
                    Please <a href="" class="text-base">contact us</a> for any queries, we’re always happy to help. 
                </div>
                <div>
                    Thanks & Regards,
                </div>
                <div class="mb-4">
                    6amMart
                </div>
            </td>
        </tr>
        <tr>
            <td>
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
    </tbody>
</table>

    
</body>
</html>
