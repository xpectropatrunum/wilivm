@extends('admin.layouts.master')

@section('title', 'Add new block user')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add new block user</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.blocked_users.index') }}">all blocked users</a></li>
                <li class="breadcrumb-item active">Add new block user</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add new block user</h3>
                </div>
                <form action="{{ route('admin.blocked_users.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="form-group col-lg-4">
                                <label>User</label>
                                <select name="user_id" class="form-control" id="search-user" required>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-4">
                                <label>From date time:</label>
                                <input type="text" name="from_datetime" id="from-datetime" class="form-control @error('from_datetime') is-invalid @enderror" value="{{ old('from_datetime') }}" required>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>To date time:</label>
                                <input type="text" name="to_datetime" id="to-datetime" class="form-control @error('to_datetime') is-invalid @enderror" value="{{ old('to_datetime') }}" required>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-12">
                                <label>Description</label>
                                <textarea name="description" class="editor form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-6">
                                <label>Enable</label>
                                <div class="form-check">
                                    <input type="checkbox" name="enable" class="form-check-input" value="1" id="exampleCheck1" {{ old('enable','checked') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1"> Yes</label>
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
            $("#search-user").select2({
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('admin.blocked_users.search_user_ajax') }}',
                    dataType: "json",
                    type: "GET",
                    delay: 500,
                    data: function (params) {
                        var queryParameters = {
                            q: params.term,
                            _token: "{{ csrf_token() }}",
                        }
                        return queryParameters;
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

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
