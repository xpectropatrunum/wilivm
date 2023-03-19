@extends('user.layouts.master')

@section('title', __('admin.profile'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('admin.profile') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('admin.profile') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Edit information</h5>
                </div>
                <form action="{{ route('user.profile.update_info') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('admin.username') }}</label>

                            <input type="text" readonly class="form-control-plaintext" value="{{ auth()->user()->username }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.email') }}</label>

                            <input type="text" readonly class="form-control-plaintext" value="{{ auth()->user()->email }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.first_name') }}</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="{{ __('admin.first_name') }}" name="first_name" value="{{ old('first_name',auth()->user()->first_name) }}" required autocomplete="first_name" autofocus>
                            @error('first_name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.last_name') }}</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" placeholder="{{ __('admin.last_name') }}" name="last_name" value="{{ old('last_name',auth()->user()->last_name) }}" required autocomplete="last_name">
                            @error('last_name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="exampleFormControlFile1">{{ __('admin.image') }}</label>
                            <input type="file" name="image" onchange="readURL(this)" class="form-control-file" id="exampleFormControlFile1">
                            <img class="img-fluid img-rounded pic-preview bg-light" @if(auth()->user()->image) src="{{ asset('storage/admins/'.auth()->user()->image) }}" @endif width="100" height="100" alt="">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">{{ __('admin.change_password') }}</h5>
                </div>
                <form action="{{ route('user.profile.change_password') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.current_password') }}</label>
                            <input type="text" value="{{ old('password') }}" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.new_password') }}</label>
                            <input type="text" value="{{ old('new-password') }}" name="new-password" class="form-control @error('new-password') is-invalid @enderror" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.retype_new_password') }}</label>
                            <input type="text" value="{{ old('new-password-confirmation') }}" name="new-password-confirmation" class="form-control @error('new-password-confirmation') is-invalid @enderror" required>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('admin_css')

@endpush

@push('admin_js')

@endpush
