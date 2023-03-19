<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }} - {{ web_title }}</title>
    <link rel="stylesheet" href="{{asset("assets/css/main/app.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/pages/error.css")}}">
    <link rel="shortcut icon" href="{{asset("assets/images/logo/favicon.svg")}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset("assets/images/logo/favicon.png")}}" type="image/png">
</head>

<body>
    <script src="{{asset("assets/js/initTheme.js")}}"></script>
    <div id="error">
        @yield('content')
    </div>
</body>

</html>