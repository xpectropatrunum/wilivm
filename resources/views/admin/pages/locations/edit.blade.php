@extends('admin.layouts.master')

@section('title', 'edit location')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">edit location</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.locations.index') }}">List locations</a></li>
                <li class="breadcrumb-item active">edit location</li>
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
                    <h3 class="card-title">edit location</h3>
                </div>
                <form action="{{ route('admin.locations.update', $location->id) }}" method="post">
                    @method("PUT")
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label> name</label>
                                <input type="text" value="{{ old('name', $location->name) }}" name="name" class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label> price</label>
                                <input type="text" value="{{ old('price',  $location->price) }}" name="price" class="form-control @error('price') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>active</label>
                                <div class="form-check">
                                    <input type="checkbox" name="enabled" class="form-check-input" value="1"
                                        id="exampleCheck2" @if (old('enabled', $location->enabled)) checked @endif>
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

