@extends('admin.layouts.master')

@section('title', 'Error 403')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Error 403</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">403 Forbidden</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="error-page">
        <h2 class="headline text-warning"> 403</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops. Something went wrong</h3>

            <p>You are not allowed to perform this action</p>
        </div>
        <!-- /.error-content -->
    </div>
@endsection
