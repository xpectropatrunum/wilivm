@extends('admin.layouts.master')

@section('title', 'Edit user')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit user</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">List users</a></li>
                <li class="breadcrumb-item active">Edit user</li>
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
                    <h3 class="card-title">Edit user</h3>
                </div>
                <form action="{{ route('admin.users.update', $user->id) }}" method="post">
                    @method("PUT")
                    @csrf
                    <input type="hidden" name="source" value="{{ config('global.user_source') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>First name</label>
                                <input type="text" value="{{ old('first_name', $user->first_name) }}" name="first_name" class="form-control @error('first_name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Last name</label>
                                <input type="text" value="{{ old('last_name', $user->last_name) }}" name="last_name" class="form-control @error('last_name') is-invalid @enderror" required>
                            </div>
                    
                        
                            <div class="form-group col-lg-3">
                                <label>Email</label>
                                <input type="email" value="{{ old('email', $user->email) }}" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Phone</label>
                                <input type="phone" value="{{ old('phone', $user->phone) }}" name="phone" class="form-control @error('phone') is-invalid @enderror" required>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>Country</label>
                                <select name="country" class="form-control select2">
                                    @foreach ($countries as $item)
                                        <option value="{{ $item->name }}"
                                            @if ($item->name == old('country', $user->country))) selected @endif>
                                            {{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>State</label>
                                <input type="state" value="{{ old('state', $user->state) }}" name="state" class="form-control @error('state') is-invalid @enderror" required>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>City</label>
                                <input type="city" value="{{ old('city', $user->city) }}" name="city" class="form-control @error('city') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Password</label>
                                <input type="text" value="{{ old('password') }}" name="password" class="form-control @error('password') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-9">
                                <label>Address</label>
                                <input type="address" value="{{ old('address', $user->address) }}" name="address" class="form-control @error('address') is-invalid @enderror" required>
                            </div>
                          
                            <div class="form-group col-lg-3">
                                <label>Repeat password</label>
                                <input type="text" value="{{ old('password_confirm') }}" name="password_confirm" class="form-control @error('password_confirm') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Active</label>
                                <div class="form-check">
                                    <input type="checkbox" name="verified" class="form-check-input" value="1" id="exampleCheck2" @if(old('enable', $user->verified)) checked @endif>
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>
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

