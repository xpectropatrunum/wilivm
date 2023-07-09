@extends('user.layouts.auth')

@section('title', __('admin.register'))

@section('content')

    <div id="alt-body">
        <div id="login-container" class="container">
            <div class="row">
                <div class="login-right py-20 py-lg-30 d-flex flex-column align-items-center justify-content-center">

                    <a href="/" target="_blank" class="mb-0">
                        <img draggable="false" class="img-responsive" src="{{ asset('assets/images/logo/wili-white.svg') }}"
                            alt="Wilivm" width="200" height="auto">
                    </a>


                    <div id="login-anime" class="d-none d-lg-flex justify-content-center">
                        <img src="{{ asset('assets/images/logo/login.svg') }}" class="screen"
                            style="height: 367px;width: 317px;">

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
                                        Registration
                                    </h3>
                                    <span class=" py-4">

                                </div>

                                <div id="email-login" class="">

                                    <form action="{{ route('panel.register') }}" method="post" autocomplete="off"
                                        class="form fv-plugins-bootstrap fv-plugins-framework row" novalidate="novalidate"
                                        id="kt_login_signin_form">
                                        @csrf


                                        <div class="">
                                            <input type="hidden" id="g_recaptcha_response" name="g_recaptcha_response">
                                            <input type="hidden" name="action" value="validate_captcha">
                                        </div>
                                    


                                        <div class="form-group col-12 col-lg-6 fv-plugins-icon-container">
                                            <div class="d-flex justify-content-between align-items-center mb-2"
                                                style="float:left">
                                                <label class="font-size-lg text-dark-50 mb-0  text-left"
                                                    for="signin-lastname">
                                                    Last Name</label>

                                            </div>
                                            <input
                                                class="form-control ltr en-text force-ltr form-control-solid h-auto py-4 px-4 rounded-md"
                                                type="text" id="signin-lastname" name="last_name"
                                                value="{{ old('last_name') }}" autocomplete="off">
                                            <div class="fv-plugins-message-container"></div>
                                        </div>

                                        
                                        <div class="form-group  col-12 col-lg-6 fv-plugins-icon-container">
                                            <div class="d-flex justify-content-between align-items-center mb-2"
                                                style="float:left">
                                                <label class="font-size-lg text-dark-50 mb-0  text-left"
                                                    for="signin-firstname">
                                                    First Name</label>

                                            </div>
                                            <input
                                                class="form-control ltr en-text force-ltr form-control-solid h-auto py-4 px-4 rounded-md"
                                                type="text" id="signin-firstname" name="first_name"
                                                value="{{ old('first_name') }}" autocomplete="off">
                                            <div class="fv-plugins-message-container"></div>
                                        </div>

                                        <div class="form-group  col-12 fv-plugins-icon-container ">
                                            <div class="d-flex justify-content-between align-items-center mb-2"
                                                style="float:left">
                                                <label class="font-size-lg text-dark-50 mb-0  text-left" for="signin-email">
                                                    Email</label>

                                            </div>
                                            <input
                                                class="form-control ltr en-text force-ltr form-control-solid h-auto py-4 px-4 rounded-md"
                                                type="text" id="signin-email" name="email" value="{{ old('email') }}"
                                                autocomplete="off">
                                            <div class="fv-plugins-message-container"></div>
                                        </div>

                                     


                                        <div class="form-group fv-plugins-icon-container   col-12" dir="ltr">


                                            <label>Password</label>
                                            <input id="psw-input" value="" type="password" name="password" class="form-control ltr en-text force-ltr form-control-solid h-auto py-4 px-4 rounded-md"
                                            autocomplete="off">
                                            <div id="pswmeter" class="mt-3"></div>
                                            <div id="pswmeter-message" class="mt-3"></div>



                                      
                                        </div>


                                        
                                        <div class="form-group fv-plugins-icon-container  col-12">
                                            <input type="checkbox"
                                            class="m-2 "
                                            id="signin-terms" name="terms"
                                            style="float:left">
                                            <div class="d-flex justify-content-between align-items-center mb-2"
                                                style="float:left">
                                                <label class="font-size-lg text-dark-50 mb-0  text-left"
                                                    for="signin-terms">
                                                    By registering in Wilivm you accept our
                                                    <a href="https://www.wilivm.com/terms-and-conditions/" target="_blank">terms</a>
                                                     
                                                      of service </label>

                                            </div>
                                      
                                        </div>
                                      


                                        <div class="pb-lg-0 pb-5">

                                            <button type="button"
                                                class="btn btn-wili font-weight-bold font-size-h6 px-6 py-3 my-3 mr-3">
                                                <a href=" {{ route('panel.login') }}" class="font-size-lg text-white "
                                                    id="kt_login_forgot"> Back to Login</a>
                                            </button>

                                            <button type="submit" id="kt_login_signin_submit" disabled
                                                class="btn btn-success font-weight-bold font-size-h6 px-6 py-3 my-3 mr-3">
                                                Sign up
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
    <style>
        :disabled{
            cursor: context-menu!important
        }
    </style>
    <script src="{{asset('assets/js/pswmeter.min.js')}}"></script>
    <script>
    
    // Run pswmeter with options
    const myPassMeter = passwordStrengthMeter({
        containerElement: '#pswmeter',
        passwordInput: '#psw-input',
        showMessage: true,
        messageContainer: '#pswmeter-message',
        messagesList: [
          'Write your password...',
          'Easy peasy!',
          'That is a simple one',
          'That is better',
          'Yeah! that password rocks ;)'
        ],
        height: 6,
        borderRadius: 0,
        pswMinLength: 6,
        colorScore1: '#aaa',
        colorScore2: 'limegreen',
        colorScore3: 'limegreen',
        colorScore4: 'limegreen'
      });

    

      setInterval(()=>{
        if(myPassMeter.getScore() == 2){
            $("#kt_login_signin_submit").removeAttr("disabled")
        }else{
            $("#kt_login_signin_submit").attr("disabled", "disabled")
        }
      }, 1000)
   

    </script>

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
@endsection
