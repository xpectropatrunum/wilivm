@extends('admin.layouts.master')

@section('title', 'create new permission')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create new permission</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">List permissions</a></li>
                <li class="breadcrumb-item active">Create new permission</li>
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
                    <h3 class="card-title">Create new permission</h3>
                </div>
                <form action="{{ route('admin.permissions.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label>{{__("Name")}}</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror" required>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',false);
                    });
                }
                
            });
        });
    </script>
@endpush

