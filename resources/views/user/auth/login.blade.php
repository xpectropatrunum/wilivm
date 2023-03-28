@extends('user.layouts.auth')

@section('title', __('admin.sign_in'))

@section('content')


    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="/"><img src="{{ asset('assets/images/logo/wilivm-logo.png') }}" style="height: 100px;" alt="Wilivm" ></a>
                </div>
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">{{ __('admin.login_message') }}</p>


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Error</h4>
                        <p>
                            @foreach ($errors->all() as $error)
                                <strong>{{ $error }}</strong> <br>
                            @endforeach
                        </p>
                    </div>
                @endif

                @if (session()->get('error'))
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Error</h4>
                        <p>
                            <strong>{!! session()->get('error') !!}</strong> <br>
                        </p>
                    </div>
                @endif

                <form action="{{ route('panel.login.attemp') }}" method="post">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input name="email" type="text" class="form-control form-control-xl" placeholder="Email">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input name="password" type="password" class="form-control form-control-xl" placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-gray-600" for="flexCheckDefault">
                            {{ __('admin.remember_me') }}
                        </label>
                    </div>
                    @if (session('recaptcha'))
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input type="hidden" id="g_recaptcha_response" name="g_recaptcha_response">
                            <input type="hidden" name="action" value="validate_captcha">
                        </div>
                    @endif

                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-4">{{ __('admin.sign_in') }}</button>

                    <a href="{{route('redirect.google')}}"  class="btn btn-primary btn-block btn-lg shadow-lg mt-4">{{ __('Login via Google') }}</a>
                </form>
                <div class="text-center mt-5 text-lg fs-6">
                    <p class="text-gray-600"><a
                            href="{{ route('panel.register') }}">{{ __('admin.register_a_new_membership') }}</a>.</p>
                    <p><a class="font-bold" href="{{ route('panel.forget') }}">{{ __('admin.i_forgot_my_password') }}</a>.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right" style="display: flex;justify-content: center">
                <img src="{{asset("assets/illustration/login.svg")}}" style="max-height: 100vh;" alt="">

            </div>
        </div>
    </div>

    @if (session('recaptcha'))
        <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE') }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ env('RECAPTCHA_SITE') }}', {
                        action: 'validate_captcha'
                    })
                    .then(function(token) {
                        document.getElementById('g_recaptcha_response').value = token;
                    });
            });
        </script>
    @endif

@endsection
