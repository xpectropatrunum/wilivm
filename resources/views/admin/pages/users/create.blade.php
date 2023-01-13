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
                            <div class="form-group col-lg-3">
                                <label>first name</label>
                                <input type="text" value="{{ old('first_name') }}" name="first_name" class="form-control @error('first_name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>last name</label>
                                <input type="text" value="{{ old('last_name') }}" name="last_name" class="form-control @error('last_name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>account type</label>
                                <select name="account_type" class="form-control">
                                    @foreach(config('global.account_types') as $key=>$type)
                                        <option value="{{ $key }}" @if(old('account_type') == $key) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>salutation</label>
                                <select name="salutation" class="form-control">
                                    @foreach(config('global.salutation') as $key=>$type)
                                        <option value="{{ $key }}" @if(old('salutation') == $key) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>powernation id</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">{{ config('global.prefix_powernation_id') }}</span>
                                    </div>
                                    <input type="text" name="powernation_id" value="{{ old('powernation_id') }}" class="form-control">
                                    <div class="input-group-append" id="button-addon4">
                                        <button class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="right" title="Generate Serial" type="button" onclick="generateSerial()"><i class="fa fa-bolt"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>national number</label>
                                <input type="text" value="{{ old('national_id') }}" name="national_id" class="form-control @error('national_id') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>company name</label>
                                <input type="text" value="{{ old('company_name') }}" name="company_name" class="form-control @error('company_name') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>phone</label>
                                <input type="text" value="{{ old('phone') }}" name="phone" class="form-control @error('phone') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>email</label>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>country</label>
                                <select name="country_id" class="form-control select2" required>
                                    <option></option>
                                    @foreach($countries as $key=>$type)
                                        <option value="{{ $key }}" @if(old('country_id') == $key) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>state</label>
                                <select name="state_id" class="form-control select2" required>
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>city</label>
                                <select name="city_id" class="form-control select2" required>
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>date</label>
                                <input type="text" placeholder="YYYY-mm-dd" id="birth-date" value="{{ old('birth_date') }}" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>nickname</label>
                                <input type="text" value="{{ old('nickname') }}" name="nickname" class="form-control @error('nickname') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>blood type</label>
                                <select name="blood_type" class="form-control">
                                    <option value="0">Blood Type:</option>
                                    @foreach(config('global.blood_types') as $key=>$type)
                                        <option value="{{ $key }}" @if(old('blood_type') == $key) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-6">
                                <label>address</label>
                                <input type="text" value="{{ old('address') }}" name="address" class="form-control @error('address') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-6">
                                <label>access groups</label>
                                <select name="groups[]" class="form-control select2" multiple>
                                    <option></option>
                                    @foreach($groups as $key=>$type)
                                        <option value="{{ $key }}" @if(is_array(old('groups')) && in_array($key,old('groups'))) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>password</label>
                                <input type="text" value="{{ old('password') }}" name="password" class="form-control @error('password') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>repeat password</label>
                                <input type="text" value="{{ old('password_confirmation') }}" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>active</label>
                                <div class="form-check">
                                    <input type="checkbox" name="enable" class="form-check-input" value="1" id="exampleCheck2" @if(old('enable')) checked @endif>
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

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
    <script>
        $(function () {
            $('#birth-date').datepicker({
                language: 'en',
                // timepicker: false,
                dateFormat: "yyyy-mm-dd",
                autoClose: true
            });

            $('select[name=country_id]').on('change', function () {
                var id= $(this).val();

                $.ajax({
                    url: '{{ route('public.provinces') }}',
                    type: 'get',
                    data: {
                        'id': id,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('select[name=state_id]').html('').html(res.options);
                    }
                });
            });

            $('select[name=state_id]').on('change', function () {
                var id= $(this).val();

                $.ajax({
                    url: '{{ route('public.cities') }}',
                    type: 'get',
                    data: {
                        'id': id,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('select[name=city_id]').html('').html(res.options);
                    }
                });
            });
        });

        function generateSerial() {
            $.ajax({
                url: '{{ route('admin.users.generate-serial') }}',
                type: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (res) {
                    $('input[name="powernation_id"]').val(res);
                }
            });
        }
    </script>
@endpush

