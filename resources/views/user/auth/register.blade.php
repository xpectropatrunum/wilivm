@extends('user.layouts.auth')

@section('title', __('admin.register'))

@section('content')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="/"><img src="{{ asset('assets/images/logo/wilivm-logo.png') }}" style="height: 60px;" alt="Wilivm" ></a>
                </div>
                <h1 class="auth-title">Sign Up</h1>
                <p class="auth-subtitle mb-5">{{ __('admin.register_message') }}</p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Error</h4>
                        <p>
                                <strong>{{ $errors->all()[0] }}</strong> <br>
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

                <form action="{{ route('panel.register') }}" method="post">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input name="email" type="text" value="{{old('email')}}" class="form-control form-control-xl" placeholder="Email" required>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input name="first_name" type="text" value="{{old('first_name')}}" class="form-control form-control-xl" required
                            placeholder="First name">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input name="last_name" type="text" value="{{old('last_name')}}" class="form-control form-control-xl" placeholder="Last name" required>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input name="affiliate" type="text" value="{{old('affiliate')}}" class="form-control form-control-xl" placeholder="Affiliate code (optional)">
                        <div class="form-control-icon">
                            <i class="bi bi-ticket-perforated"></i>
                        </div>
                    </div>
                    
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
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class='text-gray-600'><a class="font-bold" href="{{ route('panel.login') }}"
                            class="text-center">{{ __('admin.i_already_have_a_membership') }}</a>.</p>
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
