<html dir="rtl">

<head>
    <link rel="stylesheet" href="https://laminor.org/assets/css/fontiran.css">
    <style>
        a {
            color: #4b8acc;
            text-decoration: none
        }

        .box {
            width: 95%;
            border-radius: 8px;
            border: solid 2px #cc2222;
            margin: =20px auto;
        }

        .title {
            background: #cc2222;
            color: white;
            padding: 20px;
            border-radius: 5px=5px 0 0;
            font-size: 25px;
        }

        .content {
            padding: 20px;
        }

        .text-center {
            text-align: center
        }

        .text-justify {
            text-align: justify
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }

        .button {
            padding: 8px 15px;
            color: white !important;
            background: #cc2222;
            text-align: center;
            border-radius: 45px;
        }
    </style>
</head>

<body dir="ltr">
    <div class="box">
        <div class="title text-medium">{{$head}}</div>
        <div class="content">
            {!! $template !!}
        </div>
    </div>
</body>

</html>
