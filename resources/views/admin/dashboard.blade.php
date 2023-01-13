@extends('admin.layouts.master')

@section('title', __('admin.dashboard'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('admin.dashboard') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('admin.dashboard') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-body">
            <h5 class="card-title">Wellcome to admin panel</h5>
        </div>
    </div><!-- /.card -->
@endsection

@push('admin_css')

@endpush

@push('admin_js')

@endpush
