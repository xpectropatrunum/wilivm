@extends('user.layouts.auth')

@section('title', __('admin.sign_in'))

@section('content')


    <div id="alt-body">
        <div id="login-container" class="container">
            <div class="row">
                <div class="login-right py-20 py-lg-40 d-flex flex-column align-items-center justify-content-center">

                    <a href="/" target="_blank" class="mb-0">
                        <img draggable="false" class="img-responsive" src="{{ asset('assets/images/logo/wili-white.svg') }}"
                        alt="Wilivm" width="200" height="auto" >
                    </a>
    

                    <div id="login-anime" class="d-none d-lg-flex justify-content-center">
                        <img src="{{asset('assets/images/logo/login.svg')}}" class="screen" style="height: 260px">
                      
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

                                    <form action="{{ route('panel.2fa') }}" method="post"
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
                                            <div class="d-flex justify-content-between mt-n5 " style="float:left">
                                                <label class="font-size-lg text-dark-50 pt-5  text-left"
                                                    for="signin-password">OTP
                                                </label>
                                            </div>
                                            <input
                                                class="form-control form-control-solid h-auto py-4 px-4 rounded-md text-left"
                                                type="text" id="signin-password" name="otp" dir="ltr">
                                            <div class="fv-plugins-message-container"></div>
                                        </div>

                                        <div class="pb-lg-0 pb-5">

                                          
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
