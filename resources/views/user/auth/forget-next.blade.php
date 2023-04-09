@extends('user.layouts.auth')

@section('title', __('Forget password'))

@section('content')

    <div id="alt-body">
        <div id="login-container" class="container">
            <div class="row">
                <div class="login-right py-20 py-lg-40 d-flex flex-column align-items-center justify-content-center">

                    <a href="/" target="_blank" id="logo" class="mb-0 mb-lg-30">
                        <img draggable="false" class="img-responsive" src="{{ asset('assets/images/logo/wilivm-logo.png') }}"
                            alt="Wilivm" width="150" height="auto">
                    </a>


                    <div id="login-anime" class="d-none d-lg-block">
                        <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/screen.svg" class="screen">
                        <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/phone.svg" class="phone"
                            style="transform: translateY(-3.82131%) translateX(-4.9229px);">
                        <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/lock.svg" class="lock">
                        <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/lock-unlocked.svg"
                            class="lock-unlocked">
                        <div class="pass">
                            <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/pass.svg" class="">
                            <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/pass.svg" class="">
                            <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/pass.svg" class="">
                            <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/pass.svg"
                                class="invisible">
                            <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/pass.svg"
                                class="invisible">
                            <img src="https://dashboard.azaronline.com/img/dashboard/login/anime/pass.svg"
                                class="invisible">
                        </div>
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
                                        {{ __('admin.reset_password') }}
                                    </h3>
                                </div>

                                <div id="email-login" class="">

                                    <form action="{{ route('panel.forget.attemp') }}" method="post"
                                        class="form fv-plugins-bootstrap fv-plugins-framework" novalidate="novalidate"
                                        id="kt_login_signin_form">
                                        @csrf
                                        <input type="hidden" name="step" value="1">
                                        <input type="hidden" name="hash" value="{{ $hash }}">
                                        <input type="hidden" name="email" value="{{ $user->email }}">
                                        <div class="form-group fv-plugins-icon-container">
                                            <div class="d-flex justify-content-between align-items-center mb-2"
                                                style="float:left">
                                                <label class="font-size-lg text-dark-50 mb-0  text-left"
                                                    for="signin-password">
                                                    Password</label>

                                            </div>
                                            <input
                                                class="form-control ltr en-text force-ltr form-control-solid h-auto py-4 px-4 rounded-md"
                                                type="password" id="signin-password" name="password" value=""
                                                autocomplete="off">
                                            <div class="fv-plugins-message-container"></div>
                                        </div>
                                        <div class="form-group fv-plugins-icon-container">
                                            <div class="d-flex justify-content-between align-items-center mb-2"
                                                style="float:left">
                                                <label class="font-size-lg text-dark-50 mb-0  text-left"
                                                    for="signin-password_confirm">
                                                    Confirm Password</label>

                                            </div>
                                            <input
                                                class="form-control ltr en-text force-ltr form-control-solid h-auto py-4 px-4 rounded-md"
                                                type="password" id="signin-password_confirm" name="password_confirm" value=""
                                                autocomplete="off">
                                            <div class="fv-plugins-message-container"></div>
                                        </div>




                                        <div class="pb-lg-0 pb-5">


                                            <button type="submit" id="kt_login_signin_submit"
                                                class="btn btn-warning font-weight-bold font-size-h6 px-6 py-3 my-3 mr-3">
                                                {{ __('Reset') }}
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

@endsection
