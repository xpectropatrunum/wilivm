<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    */

    'title' => 'admin.admin_title', // use in trans
    'footer' => 'admin.footer', //use in trans

    'order_tg' => "کاربر %name% به ایمیل %email%
سفارش شماره %number% را پرداخت کرد",

'suspension_tg' => "موعد تمدید %name% به ایمیل %email%
سفارش با شماره %number% فرا رسیده است",


    'ticket_tg' => "کاربر %name% به ایمیل %email%
تیکت با موضوع %title% ثبت کرد",
'ticket_reply_tg' => "کاربر %name% به ایمیل %email%
به تیکت با موضوع %title% پاسخ داد ",
    'new_service' => "کاربر %name% به ایمیل %email%
سفارش شماره %number% را ایجاد کرد
Type: %type%
Plan: %plan%
",



    'service_tg' => "کاربر %name% به ایمیل %email%
درخواست %request% برای سرویس %service% ثبت کرد",

    'cycle' => [
        1 => "Monthly", 3 => "Quarterly", 6 => "Semi-annually", 12 =>  "Annually"
    ],
    'user_service_status' => [
        1 => "Not set", 2 => "Active", 3 => "Expired", 4 =>  "Canceled", 5 => "Proccessing", 6 => "Refund", 7 => "Suspended", 8 => "Terminated"
    ],
    'user_transaction_status' => [
        0 => "Unpaid", 1 => "Paid", 2 => "Refund", 3 =>  "Fraud", 
    ],
    'ticket_status' => [
        0 => "User reply", 1 => "Answered", 2 => "Closed", 3 => "In proccess"
    ],
    'deploying_status' => [
        (object)[
            "status" => "Choosing available IP",
            "progress" => 30,
            "time" => 7 //in minutes
        ],
        (object)[
            "status" => "Selecting disk drivers",
            "progress" => 55,
            "time" => 15
        ],
        (object)[
            "status" => "Installing OS",
            "progress" => 90,
            "time" => 120
        ],
    ],
   
    'logo_title' => 'admin.admin_title', //use in trans
    'logo_img' => 'admin-panel/dist/img/logo.png',
    'logo_img_alt' => 'admin.admin_title', //use in trans
];
