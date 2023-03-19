@extends('admin.layouts.master')

@section('title', 'Show user')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Show user</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">List users</a></li>
                <li class="breadcrumb-item active">Show user</li>
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
                    <h3 class="card-title">Show user</h3>
                </div>
                <div>
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>first name</label>
                                <input type="text" value="{{ old('first_name', $user->first_name) }}" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror" disabled>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>last name</label>
                                <input type="text" value="{{ old('last_name', $user->last_name) }}" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror" disabled>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>account type</label>
                                <select name="type" class="form-control" disabled>
                                    @foreach (config('global.account_types') as $key => $type)
                                        <option value="{{ $key }}"
                                            @if ( $key == 1 && $user->is_organization ||  $key == 2 && !$user->is_organization) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>salutation</label>
                                <select name="salutation" class="form-control" disabled>
                                    @foreach (config('global.salutation') as $key => $type)
                                        <option value="{{ $key }}"
                                            @if (old('salutation', $user->salutation) == $key) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label>powernation id</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="basic-addon1">{{ config('global.prefix_powernation_id') }}</span>
                                    </div>
                                    <input type="text" name="powernation_id"
                                        value="{{ old('powernation_id', $user->powernation_id) }}" class="form-control"
                                        disabled>

                                </div>
                            </div>

                            <div class="form-group col-lg-2">
                                <label>un</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="basic-addon1">{{ config('global.prefix_un') }}</span>
                                    </div>
                                    <input type="text" name="un" value="{{ old('un', $user->un ?: '') }}"
                                        class="form-control" required>
                                    <div class="input-group-append" id="button-addon5">
                                        <button class="btn btn-outline-secondary" data-toggle="tooltip"
                                            data-placement="right" title="Generate ID" type="button"
                                            onclick="generateSerial()"><i class="fa fa-bolt"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-2">
                                <label>national number</label>
                                <input type="text" value="{{ old('national_id', $user->national_id) }}"
                                    name="national_id" class="form-control @error('national_id') is-invalid @enderror"
                                    disabled>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>company name</label>
                                <input type="text" value="{{ old('company_name', $user->company_name) }}"
                                    name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                                    disabled>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>phone</label>
                                <input type="text" value="{{ old('phone', $user->phone) }}" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" disabled>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>email</label>
                                <input type="email" value="{{ old('email', $user->email) }}" name="email"
                                    class="form-control @error('email') is-invalid @enderror" disabled>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>country</label>
                                <select name="country_id" class="form-control select2" disabled>

                                    <option>
                                        {{ $user->country }}</option>

                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>state</label>
                                <select name="state_id" class="form-control select2" disabled>
                                    <option>
                                        {{ $user->state }}</option>

                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>city</label>
                                <select name="city_id" class="form-control select2" disabled>
                                    <option>
                                        {{ $user->city }}</option>

                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>date</label>
                                <input type="text" placeholder="YYYY-mm-dd" id="birth-date"
                                    value="{{ date('Y-m-d', strtotime($user->birth_date)) }}" name="birth_date"
                                    class="form-control @error('birth_date') is-invalid @enderror" disabled>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>nickname</label>
                                <input type="text" value="{{ old('nickname', $user->nickname) }}" name="nickname"
                                    class="form-control @error('nickname') is-invalid @enderror" disabled>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>blood type</label>
                                <select name="blood_type" class="form-control" disabled>
                                    @if ($user->blood_type)


                                        @foreach (config('global.blood_types') as $key => $type)
                                            <option value="{{ $key }}"
                                                @if (old('blood_type', $user->blood_type) == $key) selected @endif>{{ $type }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-6">
                                <label>address</label>
                                <input type="text" value="{{ old('address', $user->address) }}" name="address"
                                    class="form-control @error('address') is-invalid @enderror" disabled>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                    disabled>{{ old('description', $user->description) }}</textarea>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-6">
                                <label>access groups</label>
                                <select name="groups[]" class="form-control select2" multiple disabled>

                                    @foreach ($user->groups as $type)
                                        <option selected>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>active</label>
                                <div class="form-check">
                                    <input disabled type="checkbox" name="enable" class="form-check-input"
                                        value="1" id="exampleCheck2"
                                        @if (old('enable', $user->enable)) checked @endif>
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>
                            @if ($user->identity_image)
                                <div class="w-100"></div>
                                <div class="form-group">
                                    <label for="">Identity Image</label>
                                    <div>
                                        <img class="img-fluid img-rounded bg-light object-fit-cover slb" width="150"
                                            height="150" src="{{ $user->identity_image }}">

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/simplebox/simplebox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script>
        function generateSerial() {
            $.ajax({
                url: '{{ route('admin.users.generate-un', $user->id) }}',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    if(res.success){
                        $('input[name="un"]').val(res.un);
                         Toast.fire({
                            icon: 'success',
                            'title': res.msg
                        })
                    }else{
                        Toast.fire({
                            icon: 'error',
                            'title': res.msg
                        })
                    }
                }
            });
        }
    </script>
@endpush
