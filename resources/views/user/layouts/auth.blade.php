<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title', trans(config('admin.title')))
    </title>

   
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/fontawesome-free/css/all.min.css') }}">
    <link href="{{ asset('assets/css/auth/style.css') }}" rel="stylesheet" type="text/css">

    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">

    {{-- Custom Stylesheets --}}
    @stack('admin_css')
</head>


<body id="kt_body" class="login-body">
    @yield('content')

   
    @stack('admin_js')
</body>

</html>
