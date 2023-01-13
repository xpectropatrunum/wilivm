@extends('admin.layouts.auth')

@section('title', __('admin.password_reset'))

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <h3>{{ __('admin.admin_title') }}</h3>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('admin.password_reset_message') }}</p>

                <form action="{{ route('admin.password.email') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('admin.email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('admin.send_password_reset_link') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('admin.login') }}">{{ __('admin.sign_in') }}</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('admin.register') }}" class="text-center">{{ __('admin.register_message') }}</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection

@push('admin_css')

@endpush

@push('admin_js')

@endpush
