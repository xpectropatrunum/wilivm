@extends('admin.layouts.master')

@section('title', 'Create admin')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create admin</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">List admins</a></li>
                <li class="breadcrumb-item active">Create admin</li>
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
                    <h3 class="card-title">Create admin</h3>
                </div>
                <form action="{{ route('admin.admins.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="source" value="{{ config('global.admin_source') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>username</label>
                                <input type="text" value="{{ old('username') }}" name="username" class="form-control @error('username') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>phone</label>
                                <input type="text" value="{{ old('phone') }}" name="phone" class="form-control @error('phone') is-invalid @enderror" required>
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
                            <div class="form-group col-lg-4">
                                <label>roles</label>
                                <select name="roles[]" multiple class="form-control select2">
                                    @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                        <option value="{{ $role->id }}">
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>sms</label>
                                <select name="sms[]" multiple class="form-control select2">
                                    @foreach (App\Enums\ESmsType::asSelectArray() as $key => $sms)
                                        <option value="{{ $key }}" >
                                            {{ $sms }}</option>
                                    @endforeach
                                </select>
                            </div>
                           
                        </div>
                    </div>

                    <div class="card-footer text-left">
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

