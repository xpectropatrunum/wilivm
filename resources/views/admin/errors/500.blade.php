@extends('admin.layouts.error')

@section('title', 'خطای 500')

@section('content')
    <div class="error-page">
        <h2 class="headline text-warning"> 500</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> اه باز سرور پوکید!</h3>

            <p>خطایی در سرور رخ داده است، لطفا دقایقی دیگر دوباره تلاش کنید و یا با بخش فنی هماهنگ کنید</p>

            <button type="button" class="btn btn-outline-warning" onclick="history.back()">بازگشت</button>
        </div>
        <!-- /.error-content -->
    </div>
@endsection
