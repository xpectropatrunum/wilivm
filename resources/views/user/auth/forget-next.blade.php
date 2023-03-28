@extends('user.layouts.auth')

@section('title', __('Forget password'))

@section('content')


    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="/"><img src="{{ asset('assets/images/logo/wilivm-logo.png') }}" style="height: 60px;" alt="Wilivm" ></a>
                </div>
                <h1 class="auth-title">{{ __('admin.reset_password') }}</h1>
                <p class="auth-subtitle mb-5">{{ __('admin.password_reset_message') }}</p>


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
                            <strong>{{ session()->get('error') }}</strong> <br>
                        </p>
                    </div>
                @endif
                @if (session()->get('success'))
                    <div class="alert alert-success">
                        <h4 class="alert-heading">Success</h4>
                        <p>
                            <strong>{{ session()->get('success') }}</strong> <br>
                        </p>
                    </div>
                @endif
                <form action="{{ route('panel.forget.attemp') }}" method="post">
                    @csrf
                    <input type="hidden" name="step" value="1">
                    <input type="hidden" name="hash" value="{{$hash}}">
                    <input type="hidden" name="email" value="{{$user->email}}">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input name="password" type="password" class="form-control form-control-xl" placeholder="Password" required>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input name="password_confirm" type="password" class="form-control form-control-xl"
                            placeholder="Confirm Password" required>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <button
                        class="btn btn-primary btn-block btn-lg shadow-lg mt-4">{{ __('Reset') }}</button>
                </form>
                <div class="text-center mt-5 text-lg fs-6">
                    <p class="text-gray-600"><a
                            href="{{ route('panel.register') }}">{{ __('admin.register_a_new_membership') }}</a>.</p>
                    <p><a class="font-bold"
                            href="{{ route('panel.login') }}">{{ __('admin.i_already_have_a_membership') }}</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
                <img src="{{asset("assets/illustration/login.svg")}}" style="max-height: 100vh;" alt="">

            </div>
        </div>
    </div>
@endsection
