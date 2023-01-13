<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    {{-- Base Stylesheets --}}
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    @if(app()->getLocale() == 'fa')
        <link rel="stylesheet" href="{{ asset('admin-panel/libs/bootstrap/css/bootstrap-rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/dist/css/adminlte-rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('admin-panel/libs/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/dist/css/adminlte.min.css') }}">
    @endif

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('admin-panel/dist/img/favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('admin-panel/dist/img/favicon.ico') }}" type="image/x-icon" />

    {{-- Custom Stylesheets --}}
    @stack('admin_css')
</head>

<body class="hold-transition login-page text-sm">
    @yield('content')

    {{-- status Alert --}}
    @if(session('status'))
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
            {{session('status')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if ($errors->any())
    echo 9;
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <ul class="list-unstyled m-0">
                @foreach ($errors->all() as $error)
                    <li><strong>{{ $error }}</strong></li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{session('status')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <script src="{{ asset('admin-panel/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('admin-panel/dist/js/adminlte.min.js') }}"></script>

    <script>
        //close the alert after 3 seconds.
        $(document).ready(function(){
            setTimeout(function() {
                $(".alert").alert('close');
            }, 5000);
        });
    </script>

    {{-- Custom Scripts --}}
    @stack('admin_js')
</body>

</html>
