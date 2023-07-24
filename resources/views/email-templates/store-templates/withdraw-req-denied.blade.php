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
            --base: #006161;
            --clr-base: #107980
        }

        .main-table {
            width: 500px;
            background: #FFFFFF;
            margin: 0 auto;
            padding: 35px;
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
        .w-100 {
            width: 100%;
        }
        a {
            text-decoration: none;
        }
        .bg-section {
            background: #F6F6F6;
        }
        table.bg-section {
            color: #334257;
        }
        .p-10{
            padding: 10px;
        }
        table.bg-section tr th,
        table.bg-section tr td {
            padding: 5px;
        }
        .text-base {
            color: var(--base);
font-weight: 700
        }
        .text-danger {
            font-weight: 700;
            color: #FF6D6D
        }
    </style>

</head>


<body>


<table class="main-table">
    <tbody>
        <tr>
            <td class="main-table-td">
                <div class="text-center">
                <img src="{{asset('/public/assets/admin/img/withdraw-denied.png')}}" alt="">
                    <h2>Withdraw Request Denied !</h2>
                    <div class="mb-2">Transaction ID - 23984357sd834</div>
                    <div class="mb-2">Your request to withdraw money from wallet has been denied by admin</div>
                    <div class="mb-4"><a href="" class="text-danger">Note from admin :</a>Please review this withdraw request. </div>
                </div>
                <table class="bg-section p-10 w-100 text-center">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Transaction ID</th>
                            <th>Time</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>23984357sd834</td>
                            <td>23 Jul, 2023 3:34 am</td>
                            <td>$500</td>
                        </tr>
                    </tbody>
                </table>
                <span class="d-block text-center" style="margin-top: 16px">
                    <a href="" class="cmn-btn">View Request</a>
                </span>
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
