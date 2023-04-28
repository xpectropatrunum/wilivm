@extends('admin.layouts.auth')

@section('title', __('admin.sign_in'))

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <h3>{{ __('admin.admin_title') }}</h3>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('admin.login_message') }}</p>

                <form action="{{ route('admin.2fa') }}" method="post">
                    @csrf

                    @if (session('QR_Image'))
                        Scan QR code in Google Authenticator
                    @endif
                    <div class="row">
                        @if (session('QR_Image'))
                            {!! session('QR_Image') !!}
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('otp') is-invalid rounded-right @enderror"
                            placeholder="OTP" name="otp">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>


                    </div>

                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
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

                {{--  <p class="mb-1">
                    <a href="{{ route('admin.password.request') }}">{{ __('admin.i_forgot_my_password') }}</a>
                </p>  --}}
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

{{--  @push('admin_js')
    <script>
        function reloadCaptcha() {
            $.ajax({
                type: 'GET',
                url: '{{ route('captcha.reload') }}',
                success: function (data) {
                    $(".captcha-image img").attr('src',data.captcha);
                }
            });
        }
    </script>
@endpush  --}}
