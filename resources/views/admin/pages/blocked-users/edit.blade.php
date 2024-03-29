@extends('admin.layouts.master')

@section('title', 'Edit block user')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit block user</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.blocked-users.index') }}">all blocked users</a></li>
                <li class="breadcrumb-item active">Edit block user</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit block user</h3>
                </div>
                <form action="{{ route('admin.blocked-users.update', $blockedUser->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-lg-4">
                                <label>User</label>
                                <select name="user_id" class="form-control select2" id="search-user" required>
                                    @foreach (App\Models\User::all() as $item)
                                        <option @if ($item->id == $blockedUser->user_id) selected @endif
                                            value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }} -
                                            {{ $item->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>From date time:</label>
                                <input type="text" name="from_datetime" id="from-datetime"
                                    class="form-control @error('from_datetime') is-invalid @enderror"
                                    value="{{ old('from_datetime', $blockedUser->from_datetime) }}" required>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>To date time:</label>
                                <input type="text" name="to_datetime" id="to-datetime"
                                    class="form-control @error('to_datetime') is-invalid @enderror"
                                    value="{{ old('to_datetime', $blockedUser->to_datetime) }}" required>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-12">
                                <label>Description</label>
                                <textarea name="description" class="editor form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $blockedUser->description) }}</textarea>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-6">
                                <label>Enable</label>
                                <div class="form-check">
                                    <input type="checkbox" name="enable" class="form-check-input" value="1"
                                        id="exampleCheck1" {{ old('enable', $blockedUser->enable) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1"> Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">{{ __('admin.edit') }}</button>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
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
         

            $('#from-datetime,#to-datetime').datepicker({
                language: 'en',
                timepicker: true,
                dateFormat: "yyyy-mm-dd",
                timeFormat: "hh:ii",
                autoClose: true
            });
        });
    </script>
@endpush
