@extends('admin.layouts.master')

@section('title', 'create new user')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create new user</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">List users</a></li>
                <li class="breadcrumb-item active">Create new user</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create new user</h3>
                </div>
                <form action="{{ route('admin.users.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="source" value="{{ config('global.user_source') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>first name</label>
                                <input type="text" value="{{ old('first_name') }}" name="first_name" class="form-control @error('first_name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>last name</label>
                                <input type="text" value="{{ old('last_name') }}" name="last_name" class="form-control @error('last_name') is-invalid @enderror" required>
                            </div>
                    
                        
                            <div class="form-group col-lg-4">
                                <label>email</label>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            </div>
                        
                            <div class="form-group col-lg-4">
                                <label>password</label>
                                <input type="text" value="{{ old('password') }}" name="password" class="form-control @error('password') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>repeat password</label>
                                <input type="text" value="{{ old('password_confirm') }}" name="password_confirm" class="form-control @error('password_confirm') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>active</label>
                                <div class="form-check">
                                    <input type="checkbox" name="verified" class="form-check-input" value="1" id="exampleCheck2" @if(old('enable')) checked @endif>
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.en.js') }}"></script>
    
@endpush

