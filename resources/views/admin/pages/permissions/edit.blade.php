@extends('admin.layouts.master')

@section('title', 'Update permission')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update permission</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">List permissions</a></li>
                <li class="breadcrumb-item active">Update permission</li>
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
                    <h3 class="card-title">Update permission</h3>
                </div>

                <form method="POST" action="{{ route('admin.permissions.update', $permission->id) }}">
                    @method('patch')
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label>{{__("Name")}}</label>
                                <input type="text" value="{{ old('name', $permission->name) }}" name="name" class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-12">
                            
             
                    </div>
           <div class="col-12">
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

