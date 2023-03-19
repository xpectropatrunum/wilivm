@extends('admin.layouts.error')

@section('title', 'Error 404')

@section('content')
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops. Something went wrong</h3>

            <p>Page not found.</p>

            <button type="button" class="btn btn-outline-warning" onclick="history.back()">Back</button>
        </div>
        <!-- /.error-content -->
    </div>
@endsection
