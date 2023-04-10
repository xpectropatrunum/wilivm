@extends('user.layouts.auth')

@section('title', __('admin.sign_in'))

@section('content')


    <div id="alt-body">
        <div id="login-container" class="container">
            <div class="row">
                <div class="login-right py-20 py-lg-40 d-flex flex-column align-items-center justify-content-center">

                    <a href="/" target="_blank" class="mb-0">
                        <img draggable="false" class="img-responsive" src="{{ asset('assets/images/logo/wili-white.svg') }}"
                            alt="Wilivm" width="250" height="auto" >
                    </a>
    

                    <div id="login-anime" class="d-none d-lg-flex justify-content-center">
                        <img src="{{asset('assets/images/logo/login.svg')}}" class="screen">
                      
                    </div>

                </div>
                <div class="col bg-white login login-1 login-left login-signin-on" id="kt_login">

                    <div
                        class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden px-7 py-7 py-lg-27 mx-auto">

                        <div class="row justify-content-center mb-5">
                            <div class="col-11 col-sm-7 col-md-5 col-lg-10 col-xl-9 px-xl-10">
                                <div class="row">
                                    <div class="col-12">

                                        @if (session('error'))
                                            <div dir="ltr"
                                                class="alert alert-custom flex-column align-items-center flex-sm-row alert-light-danger mb-5"
                                                role="alert">

                                                <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i>
                                                </div>
                                                <div class="alert-text pr-5 mb-5 mt-2 mb-sm-0 mt-sm-0 text-left">
                                                    <p class="m-0">{{ session('error') }}</p>
                                                </div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif


                                        @if ($errors->any())
                                            <div dir="ltr"
                                                class="alert alert-custom flex-column align-items-center flex-sm-row alert-light-danger mb-5"
                                                role="alert">

                                                <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i>
                                                </div>
                                                <div class="alert-text pr-5 mb-5 mt-2 mb-sm-0 mt-sm-0 text-left">
                                                    <p class="m-0">{{ $errors->first() }}</p>
                                                </div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Success Alert --}}
                                        @if (session('success'))
                                            <div dir="ltr"
                                                class="alert alert-custom flex-column align-items-center flex-sm-row alert-light-success mb-5"
                                                role="alert">

                                                <div class="alert-icon"><i class="fas fa-check"></i>
                                                </div>
                                                <div class="alert-text pr-5 mb-5 mt-2 mb-sm-0 mt-sm-0 text-left">
                                                    <p class="m-0">{{ session('success') }}</p>
                                                </div>
                                                <div class="alert-close">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif



                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column-fluid flex-center">

                            <div class="login-form login-signin text-left">

                                <div class="pb-10 pt-lg-0 pt-5">
                                    <h3 class="font-weight-bolder text-dark font-size-h4 mb-5">
                                        Login To Dashboard
                                    </h3>
                                    

                                </div>

                                <div id="email-login" class="">

                                    <form action="{{ route('panel.login.attemp') }}" method="post"
                                        class="form fv-plugins-bootstrap fv-plugins-framework" novalidate="novalidate"
                                        id="kt_login_signin_form">
                                        @csrf

                                        @if (session('recaptcha'))
                                            <div class="form-check form-check-lg d-flex align-items-end">
                                                <input type="hidden" id="g_recaptcha_response"
                                                    name="g_recaptcha_response">
                                                <input type="hidden" name="action" value="validate_captcha">
                                            </div>
                                        @endif
                                        <div class="form-group fv-plugins-icon-container">
                                            <div class="d-flex justify-content-between align-items-center mb-2"
                                                style="float:left">
                                                <label class="font-size-lg text-dark-50 mb-0  text-left"
                                                    for="signin-email">
                                                    Email</label>

                                            </div>
                                            <input
                                                class="form-control ltr en-text force-ltr form-control-solid h-auto py-4 px-4 rounded-md"
                                                type="text" id="signin-email" name="email" value=""
                                                autocomplete="off">
                                            <div class="fv-plugins-message-container"></div>
                                        </div>


                                        <div class="form-group fv-plugins-icon-container">
                                            <div class="d-flex justify-content-between mt-n5 " style="float:left">
                                                <label class="font-size-lg text-dark-50 pt-5  text-left"
                                                    for="signin-password">Password
                                                </label>
                                            </div>
                                            <input
                                                class="form-control form-control-solid h-auto py-4 px-4 rounded-md text-left"
                                                type="password" id="signin-password" name="password" dir="ltr">
                                            <div class="fv-plugins-message-container"></div>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between">
                                            <label class="checkbox font-size-lg text-dark-50 user-select-none">
                                                Remember me
                                                <input type="checkbox" name="remember_me" class="mr-2 ltr en-text"
                                                    value="1">
                                                <span class="mr-2"></span>

                                            </label>

                                            <div dir="ltr"> <a href=" {{ route('panel.register') }}"
                                                    class="font-size-lg text-dark-50 text-hover-warning"
                                                    id="kt_login_forgot"> Signup</a> / <a
                                                    href="{{ route('panel.forget') }}"
                                                    class="font-size-lg text-dark-50 text-hover-warning"
                                                    id="kt_login_forgot"> Forget Password?</a></div>

                                        </div>


                                        <div class="pb-lg-0 pb-5">

                                            <a href="{{ route('redirect.google') }}"
                                                class="btn btn-success font-weight-bold px-6 py-3 my-3 font-size-lg">
                                                <span class="svg-icon svg-icon-md">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M19.9895 10.1871C19.9895 9.36767 19.9214 8.76973 19.7742 8.14966H10.1992V11.848H15.8195C15.7062 12.7671 15.0943 14.1512 13.7346 15.0813L13.7155 15.2051L16.7429 17.4969L16.9527 17.5174C18.879 15.7789 19.9895 13.221 19.9895 10.1871Z"
                                                            fill="#4285F4"></path>
                                                        <path
                                                            d="M10.1993 19.9313C12.9527 19.9313 15.2643 19.0454 16.9527 17.5174L13.7346 15.0813C12.8734 15.6682 11.7176 16.0779 10.1993 16.0779C7.50243 16.0779 5.21352 14.3395 4.39759 11.9366L4.27799 11.9466L1.13003 14.3273L1.08887 14.4391C2.76588 17.6945 6.21061 19.9313 10.1993 19.9313Z"
                                                            fill="#34A853"></path>
                                                        <path
                                                            d="M4.39748 11.9366C4.18219 11.3166 4.05759 10.6521 4.05759 9.96565C4.05759 9.27909 4.18219 8.61473 4.38615 7.99466L4.38045 7.8626L1.19304 5.44366L1.08875 5.49214C0.397576 6.84305 0.000976562 8.36008 0.000976562 9.96565C0.000976562 11.5712 0.397576 13.0882 1.08875 14.4391L4.39748 11.9366Z"
                                                            fill="#FBBC05"></path>
                                                        <path
                                                            d="M10.1993 3.85336C12.1142 3.85336 13.406 4.66168 14.1425 5.33717L17.0207 2.59107C15.253 0.985496 12.9527 0 10.1993 0C6.2106 0 2.76588 2.23672 1.08887 5.49214L4.38626 7.99466C5.21352 5.59183 7.50242 3.85336 10.1993 3.85336Z"
                                                            fill="#EB4335"></path>
                                                    </svg>

                                                </span> {{ __('Google') }}
                                            </a>
                                            <button type="submit" id="kt_login_signin_submit"
                                                class="btn btn-success font-weight-bold font-size-h6 px-6 py-3 my-3 mr-3">
                                                Login
                                            </button>
                                        </div>

                                        <input type="hidden">
                                        <div></div>
                                    </form>
                                </div>


                            </div>






                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    @if (session('recaptcha'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ $settings['RECAPTCHA_SITE'] }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ $settings['RECAPTCHA_SITE'] }}', {
                        action: 'validate_captcha'
                    })
                    .then(function(token) {
                        document.getElementById('g_recaptcha_response').value = token;
                    });
            });
        </script>
    @endif
@endsection
