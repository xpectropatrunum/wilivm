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

                <form action="{{ route('admin.login.attemp') }}" method="post">
                    @csrf
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
                    {{--  <div class="input-group mb-2">
                        <div class="captcha-image">{!! captcha_img('flat') !!}</div> 
                        <button type="button" class="btn btn-secondary ml-2" onclick="reloadCaptcha()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                            </svg>
                        </button>
                    </div>  --}}

                    {{--  <div class="form-group mb-3">
                        <input type="text" class="form-control @error('captcha') is-invalid rounded-right @enderror" placeholder="{{ __('admin.enter_captcha') }}" name="captcha" value="{{ old('captcha') }}" style="width: 125px" required>

                        @error('captcha')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>  --}}

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
