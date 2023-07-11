<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex" />

    @yield('meta_tags')
    <title> @yield('title') - Wilivm</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/fa.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/swal.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">
    @stack('admin_css')

</head>

<body>
    <script src="{{ asset('assets/js/initTheme.js') }}"></script>
    <div id="app">


        <div id="sidebar" class="active">
            @include('user.partials.sidebar-menu')

        </div>




        <div class="header-top">
            <div>

                <div class="header-top-right d-flex align-items-center">
                    <a href="{{ route('panel.wallet') }}" class="d-none d-xl-block">
                        <div class="my-wallet btn btn-outline-primary btn-md" style="margin-right: 5px">

                            <i class="fa fa-plus"></i>
                          Add Funds



                        </div>

                    </a>
                    <a href="{{ route('panel.wallet') }}">
                        <div class="my-wallet btn btn-outline-primary btn-md">

                            <i class="fa fa-wallet"></i>
                            ${{ auth()->user()->wallet->balance }}



                        </div>

                    </a>
                    <div class="dropdown">
                        <a href="#" id="topbarUserDropdown"
                            class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div id="profileImage">
                            </div>
                            <div class="text">
                                <h6 class="user-dropdown-name"><span
                                        id="first_name">{{ auth()->user()->first_name }}</span> <span class="pl-1"
                                        id="last_name">{{ auth()->user()->last_name }}</span></h6>
                                <p class="user-dropdown-status text-sm text-muted">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown"
                            style="">
                            <li><a class="dropdown-item" href="{{ route('panel.settings') }}">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('panel.logout') }}">Logout</a>
                            </li>
                        </ul>
                    </div>



                </div>
            </div>
        </div>

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            @if ($errors->any())

                <div class="alert alert-danger alert-dismissible show fade">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>



            @endif

            @if (session()->get('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    {{ session()->get('error') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->get('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    {{ session()->get('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @yield('content')

        </div>
    </div>
    <script src="{{ asset('assets/js/pages/jquery.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var firstName = $('#first_name').text();
            var lastName = $('#last_name').text();
            var intials = $('#first_name').text().charAt(0) + $('#last_name').text().charAt(0);
            var profileImage = $('#profileImage').text(intials);
        });
    </script>
    <script src="{{ asset('admin-panel/libs/ckeditor/ckeditor.js') }}"></script>

    <script>
        function initCkeditor() {
            $('.editor').each(function() {
                CKEDITOR.replace(this.id);
            });
        }
        initCkeditor()
    </script>
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/63d7b1e8c2f1ac1e203057f2/1go18ttv5';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    @stack('admin_js')

</body>

</html>
