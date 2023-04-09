@extends('admin.layouts.master')

@section('title', __('admin.general_settings'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('admin.general_settings') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('admin.general_settings') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Google recaptcha v3</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="contact">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Site Key</label>
                            <input type="text" value="{{ old('RECAPTCHA_SITE',isset($items['RECAPTCHA_SITE']) ? $items['RECAPTCHA_SITE'] : '') }}" name="settings[RECAPTCHA_SITE]" class="form-control @error('RECAPTCHA_SITE') is-invalid @enderror">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Secret Key</label>
                            <input type="text" value="{{ old('RECAPTCHA_SECRET',isset($items['RECAPTCHA_SECRET']) ? $items['RECAPTCHA_SECRET'] : '') }}" name="settings[RECAPTCHA_SECRET]" class="form-control @error('RECAPTCHA_SITE') is-invalid @enderror">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Faraz SMS</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">API Key</label>
                            <input type="text" value="{{ old('FARAZ_SMS_API_KEY',isset($items['FARAZ_SMS_API_KEY']) ? $items['FARAZ_SMS_API_KEY'] : '') }}" name="settings[FARAZ_SMS_API_KEY]" class="form-control @error('FARAZ_SMS_API_KEY') is-invalid @enderror" dir="ltr">
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Perfect Money</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Account</label>
                            <input type="text" value="{{ old('PERFECTMONEY_ACC',isset($items['PERFECTMONEY_ACC']) ? $items['PERFECTMONEY_ACC'] : '') }}" name="settings[PERFECTMONEY_ACC]" class="form-control @error('PERFECTMONEY_ACC') is-invalid @enderror" dir="ltr">
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Coinpayments</h5>
                </div>
                
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Merchant</label>
                            <input type="text" value="{{ old('COINPAYMENTS_MERCHANT',isset($items['COINPAYMENTS_MERCHANT']) ? $items['COINPAYMENTS_MERCHANT'] : '') }}" name="settings[COINPAYMENTS_MERCHANT]" class="form-control @error('COINPAYMENTS_MERCHANT') is-invalid @enderror" dir="ltr">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Secret</label>
                            <input type="text" value="{{ old('COINPAYMENTS_SECRET',isset($items['COINPAYMENTS_SECRET']) ? $items['COINPAYMENTS_SECRET'] : '') }}" name="settings[COINPAYMENTS_SECRET]" class="form-control @error('COINPAYMENTS_SECRET') is-invalid @enderror" dir="ltr">
                        </div>


                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Google login</h5>
                </div>
                
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Client Secret</label>
                            <input type="text" value="{{ old('GOOGLE_CLIENT_SECRET',isset($items['GOOGLE_CLIENT_SECRET']) ? $items['GOOGLE_CLIENT_SECRET'] : '') }}" name="settings[GOOGLE_CLIENT_SECRET]" class="form-control @error('GOOGLE_CLIENT_SECRET') is-invalid @enderror" dir="ltr">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Client ID</label>
                            <input type="text" value="{{ old('GOOGLE_CLIENT_ID',isset($items['GOOGLE_CLIENT_ID']) ? $items['GOOGLE_CLIENT_ID'] : '') }}" name="settings[GOOGLE_CLIENT_ID]" class="form-control @error('GOOGLE_CLIENT_ID') is-invalid @enderror" dir="ltr">
                        </div>


                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>

     
   
    </div>
@endsection

@push('admin_css')

@endpush

@push('admin_js')

@endpush
