@extends('admin.layouts.master')

@section('title', 'create new language')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create new language</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.languages.index') }}">List languages</a></li>
                <li class="breadcrumb-item active">Create new language</li>
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
                    <h3 class="card-title">Create new language</h3>
                </div>
                <form action="{{ route('admin.languages.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>short name</label>
                                <input type="text" value="{{ old('short_name') }}" name="short_name" class="form-control @error('short_name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-3">
                                <label>enable</label>
                                <div class="form-check">
                                    <input type="checkbox" name="enable" class="form-check-input" value="1" id="exampleCheck1" @if(old('enable')) checked @endif>
                                    <label class="form-check-label" for="exampleCheck1"> Yes</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>default</label>
                                <div class="form-check">
                                    <input type="checkbox" name="is_default" class="form-check-input" value="1" id="aaa1" @if(old('is_default')) checked @endif>
                                    <label class="form-check-label" for="aaa1"> Yes</label>
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

@endpush

@push('admin_js')
    <script>
        $(function () {

        })
    </script>
@endpush
