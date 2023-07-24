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
            margin: 0;
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
        .text-center {
            text-align: center;
        }
        .text-base {
            color: var(--base);
font-weight: 700
        }
        .font-medium {
            font-family: 500;
        }
        .font-bold {
            font-family: 700;
        }
        a {
            text-decoration: none;
        }
        .bg-section {
            background: #E3F5F1;
        }
        .p-10 {
            padding: 10px;
        }
        .mt-0{
            margin-top: 0;
        }
        .w-100 {
            width: 100%;
        }
        .order-table {
            padding: 10px;
            background: #fff;
        }
        .order-table tr td {
            vertical-align: top
        }
        .order-table .subtitle {
            margin: 0;
            margin-bottom: 10px;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .bg-section-2 {
            background: #F8F9FB;
        }
        .p-1 {
            padding: 5px;
        }
        .p-2 {
            padding: 10px;
        }
        .px-3 {
            padding-inline: 15px
        }
        .mb-0 {
            margin-bottom: 0;
        }
        .m-0 {
            margin: 0;
        }
        .text-base {
            color: var(--base);
font-weight: 700
        }
        del {
            opacity: .5;
        }
        .total-amount{
            display: flex;
            justify-content: flex-end;
            gap: 5px;
        }
    </style>

</head>


<body>


<table class="main-table">
    <tbody>
        <tr>
            <td class="main-table-td">
                <h2 class="mb-3">Your order has been refunded successfully !</h2>
                <div class="mb-1">Hi Sabrina,</div>
                <div class="mb-4">Your request for refund for the <span class="font-medium text-base">order # 38578923</span> is successfully
Refunded. The refunded amount has been transferred to your wallet.</div>
                <table class="bg-section p-10 w-100">
                    <tbody>
                        <tr>
                            <td class="p-10">
                                <span class="d-block text-center">
                                    @php($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()->value)
                                    <img style="width: 125px" class="mb-" src="{{ asset('storage/app/public/business/' . $store_logo) }}" alt="">
                                    <h3 class="mb-3 mt-0">Order Info</h3>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="order-table w-100">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h3 class="subtitle">Order Summary</h3>
                                                <span class="d-block">Order# 48573</span>
                                                <span class="d-block">23 Jul, 2023 4:30 am</span>
                                            </td>
                                            <td style="max-width:130px">
                                                <h3 class="subtitle">Delivery Address</h3>
                                                <span class="d-block">Munam Shahariar</span>
                                                <span class="d-block" >4517 Washington Ave. Manchester, Kentucky 39495</span>
                                            </td>
                                        </tr>
                                        <td colspan="2">
                                            <table class="w-100">
                                                <thead class="bg-section-2">
                                                    <tr>
                                                        <th class="text-left p-1 px-3">Product</th>
                                                        <th class="text-right p-1 px-3">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-left p-2 px-3">
                                                            1. The school of life - emotional baggage tote bag - canvas tote bag (navy) x 1
                                                        </td>
                                                        <td class="text-right p-2 px-3">
                                                            <h4>
                                                                $5,465
                                                            </h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left p-2 px-3">
                                                            2. 3USB Head Phone x 1
                                                        </td>
                                                        <td class="text-right p-2 px-3">
                                                            <h4>
                                                                $354
                                                            </h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <hr class="mt-0">
                                                            <table class="w-100">
                                                                <tr>
                                                                    <td style="width: 30%"></td>
                                                                    <td class="p-1 px-3">Item Price</td>
                                                                    <td class="text-right p-1 px-3">$85</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 30%"></td>
                                                                    <td class="p-1 px-3">Addon</td>
                                                                    <td class="text-right p-1 px-3">$85</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 30%"></td>
                                                                    <td class="p-1 px-3">Sub total</td>
                                                                    <td class="text-right p-1 px-3">$90</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 30%"></td>
                                                                    <td class="p-1 px-3">Discount</td>
                                                                    <td class="text-right p-1 px-3">$10</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 30%"></td>
                                                                    <td class="p-1 px-3">Coupon Discount</td>
                                                                    <td class="text-right p-1 px-3">$00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 30%"></td>
                                                                    <td class="p-1 px-3">VAT / Tax</td>
                                                                    <td class="text-right p-1 px-3">$15</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 30%"></td>
                                                                    <td class="p-1 px-3">Delivery Charge</td>
                                                                    <td class="text-right p-1 px-3">$20</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 30%"></td>
                                                                    <td class="p-1 px-3">
                                                                        <h4>Total</h4>
                                                                    </td>
                                                                    <td class="text-right p-1 px-3">
                                                                        <span class="text-base total-amount"><del>$105</del> $0.00</span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
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