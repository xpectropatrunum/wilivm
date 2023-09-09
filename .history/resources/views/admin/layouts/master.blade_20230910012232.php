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
    @if (app()->getLocale() == 'fa')
        <link rel="stylesheet" href="{{ asset('admin-panel/libs/bootstrap/css/bootstrap-rtl.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('admin-panel/libs/persian-datepicker/dist/css/persian-datepicker.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('admin-panel/libs/bootstrap/css/bootstrap.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/sweetalert2/sweetalert2.min.css') }}">


    {{-- Custom Stylesheets --}}
    @stack('admin_css')

    @if (app()->getLocale() == 'fa')
        <link rel="stylesheet" href="{{ asset('admin-panel/dist/css/adminlte-rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('admin-panel/dist/css/adminlte.min.css') }}">
    @endif

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('admin-panel/dist/img/favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('admin-panel/dist/img/favicon.ico') }}" type="image/x-icon" />
</head>

<body class="hold-transition layout-fixed sidebar-mini control-sidebar-slide-open text-sm">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('admin.partials.left-navbar-link')

            @include('admin.partials.right-navbar-link')
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('admin.partials.brand-logo')

            @include('admin.partials.sidebar-menu')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    @yield('content_header')

                    {{-- status Alert --}}
                    @if (session('status'))
                        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
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
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        @include('admin.partials.footer')
    </div>

    <script src="{{ asset('admin-panel/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('admin-panel/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('admin-panel/dist/js/app.js') }}"></script>
    <script>
        $(function() {
            ///searchbox

            $("[name=search]").on("input", function() {
                search = $(this).val()
                if (search.length == 0) {
                    $(".dropdown-search").css("display", "none");
                    $(".type-more").hide();
                    $(".search-users").hide()
                    $(".search-tickets").hide()
                    $(".search-orders").hide()
                    $(".search-invoices").hide()

                } else if (search.length < 3) {
                    $(".dropdown-search").css("display", "block");
                    $(".type-more").show();
                    $(".search-users").hide()
                    $(".search-tickets").hide()
                    $(".search-orders").hide()
                    $(".search-invoices").hide()
                    $(".type-more").text("Type at least 3 characters to search");
                } else {
                    $(".dropdown-search").css("display", "block");
                    $(".type-more").hide();
                    $(".search-users").show()
                    $(".search-tickets").show()
                    $(".search-orders").show()
                    $(".search-invoices").show()


                }

                $.ajax({
                    url: "{{route('admin.dashboard.search')}}",
                    type: 'post',
                    data: {
                        'search': search,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // $("#beforeAfterLoading").addClass("spinner-border");
                    },
                    complete: function() {
                        // $("#beforeAfterLoading").removeClass("spinner-border");
                    },
                    success: function(res) {
                        $(".search-users").html("")
                        $(".search-orders").html("")
                        $(".search-invoices").html("")
                        $(".search-tickets").html("")
                        res.users.map(item => {
                            $(".search-users").append(`<span
                            class="dropdown-item dropdown-header text-left cursor-pointer" ><a href="/admin/users/?search=${item.id}"><i class="nav-icon fas fa-user"></i> ${item.first_name} ${item.last_name} - ${item.email}</a></span>`)
                        })
                        res.orders.map(item => {
                            $(".search-orders").append(`<span
                            class="dropdown-item dropdown-header text-left cursor-pointer"><a href="/admin/orders/${item.id}/edit"><i class="nav-icon fas fa-shopping-cart"></i> Order #${item.id}</a></span>`)
                        })
                        res.invoices.map(item => {
                            $(".search-invoices").append(`<span
                            class="dropdown-item dropdown-header text-left cursor-pointer"><a href="/admin/invoices/${item.id}/edit"><i class="nav-icon fas fa-shopping-cart"></i> Invoice #${item.id}</a></span>`)
                        })
                        res.tickets.map(item => {
                            $(".search-tickets").append(`<span
                            class="dropdown-item dropdown-header text-left cursor-pointer"><a href="/admin/tickets/${item.id}"><i class="nav-icon fas fa-ticket-alt"></i>  Ticket #${item.id}</a></span>`)
                        })
                    },
                    error: function(res) {
                       console.log("Error")
                    }
                });
            })
            $('.changeStatus').on('change', function() {
                id = $(this).attr('data-id');

                if ($(this).is(':checked')) {
                    enable = 1;
                } else {
                    enable = 0;
                }

                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'post',
                    data: {
                        'enabled': enable,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // $("#beforeAfterLoading").addClass("spinner-border");
                    },
                    complete: function() {
                        // $("#beforeAfterLoading").removeClass("spinner-border");
                    },
                    success: function(res) {
                        Toast.fire({
                            icon: 'success',
                            'title': 'Record status successfully changed'
                        })
                    }
                });
            });
        });
    </script>
    {{-- Custom Scripts --}}
    @stack('admin_js')
</body>

</html>
