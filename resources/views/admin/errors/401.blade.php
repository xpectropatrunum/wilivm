@extends('admin.layouts.master')

@section('title', 'Error 401')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Error 401</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Unauthorized error</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="error-page">
        <h2 class="headline text-warning"> 401</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops. Something went wrong</h3>

            <p>Access is denied. please login.</p>
        </div>
        <!-- /.error-content -->
    </div>
@endsection
