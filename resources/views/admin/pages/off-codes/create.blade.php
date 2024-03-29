@extends('admin.layouts.master')

@section('title', 'Add new off code')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add new off code</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.off-codes.index') }}">all off codes</a></li>
                <li class="breadcrumb-item active">Add new off code</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add new off code</h3>
                </div>
                <form action="{{ route('admin.off-codes.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-lg-4">
                                <label>User</label>
                                <select name="user_id" class="form-control select2" required>
                                    <option value="0">All</option>
                                    @foreach (App\Models\User::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }} -
                                            {{ $item->email }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Type</label>
                                <select name="type" class="form-control" required>
                                    @foreach (App\Enums\EOffType::asSelectArray() as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Amount</label>
                                <input type="text" name="amount" 
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Code</label>
                                <input type="text" name="code" 
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Limit</label>
                                <input type="text" name="limit" 
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', 0) }}" required>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>From date time:</label>
                                <input type="text" name="from_date" id="from-datetime"
                                    class="form-control @error('from_date') is-invalid @enderror"
                                    value="{{ old('from_date') }}" required>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>To date time:</label>
                                <input type="text" name="to_date" id="to-datetime"
                                    class="form-control @error('to_date') is-invalid @enderror"
                                    value="{{ old('to_date') }}" required>
                            </div>


                            <div class="form-group col-lg-6">
                                <label>Enable</label>
                                <div class="form-check">
                                    <input type="checkbox" name="enable" class="form-check-input" value="1"
                                        id="exampleCheck1" {{ old('enable', 'checked') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1"> Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
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
        $(function() {


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
