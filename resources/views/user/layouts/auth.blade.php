<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />

    @yield('meta_tags')
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/sweetalert2/sweetalert2.min.css') }}">

</head>

<body>
    <script src="{{ asset('admin-panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/js/initTheme.js') }}"></script>
 
    <script src="{{ asset('assets/js/pages/jquery.js') }}"></script>


   

    <div id="auth">
        @yield('content')
    </div>

    
</body>

</html>
