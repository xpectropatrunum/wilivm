@extends('admin.layouts.auth')

@section('title', __('admin.sign_in'))

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <h3>{{ __('admin.admin_title') }}</h3>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('admin.login_message') }}</p>
                <form action="{{ route('admin.login.attemp') }}" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('username') is-invalid rounded-right @enderror" placeholder="{{ __('admin.username_or_email') }}" name="username" value="{{ old('username') }}" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>

                        @error('username')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid rounded-right @enderror" placeholder="{{ __('admin.password') }}" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">{{ __('admin.remember_me') }}</label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('admin.sign_in') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush


