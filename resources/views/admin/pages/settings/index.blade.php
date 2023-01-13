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
                    <h5 class="m-0">{{ __('admin.contact') }}</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="contact">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.address') }}</label>
                            <input type="text" value="{{ old('address',isset($items['address']) ? $items['address'] : '') }}" name="settings[address]" class="form-control @error('address') is-invalid @enderror">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.mobile') }}</label>
                            <input type="text" value="{{ old('mobile',isset($items['mobile']) ? $items['mobile'] : '') }}" name="settings[mobile]" class="form-control @error('mobile') is-invalid @enderror">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.tel') }}</label>
                            <input type="text" value="{{ old('tel',isset($items['tel']) ? $items['tel'] : '') }}" name="settings[tel]" class="form-control @error('tel') is-invalid @enderror">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.email') }}</label>
                            <input type="email" value="{{ old('email',isset($items['email']) ? $items['email'] : '') }}" name="settings[email]" dir="ltr" class="form-control @error('email') is-invalid @enderror">
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
                    <h5 class="m-0">{{ __('admin.socials') }}</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="social">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.telegram') }}</label>
                            <input type="text" value="{{ old('telegram',isset($items['telegram']) ? $items['telegram'] : '') }}" name="settings[telegram]" class="form-control @error('telegram') is-invalid @enderror" dir="ltr">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ 'Linkedin' }}</label>
                            <input type="text" value="{{ old('linkedin',isset($items['linkedin']) ? $items['linkedin'] : '') }}" name="settings[linkedin]" class="form-control @error('linkedin') is-invalid @enderror" dir="ltr">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.instagram') }}</label>
                            <input type="text" value="{{ old('instagram',isset($items['instagram']) ? $items['instagram'] : '') }}" name="settings[instagram]" class="form-control @error('instagram') is-invalid @enderror" dir="ltr">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.whatsapp') }}</label>
                            <input type="text" value="{{ old('whatsapp',isset($items['whatsapp']) ? $items['whatsapp'] : '') }}" name="settings[whatsapp]" class="form-control @error('whatsapp') is-invalid @enderror" dir="ltr">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.twitter') }}</label>
                            <input type="text" value="{{ old('twitter',isset($items['twitter']) ? $items['twitter'] : '') }}" name="settings[twitter]" class="form-control @error('twitter') is-invalid @enderror" dir="ltr">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __('admin.facebook') }}</label>
                            <input type="text" value="{{ old('facebook',isset($items['facebook']) ? $items['facebook'] : '') }}" name="settings[facebook]" class="form-control @error('facebook') is-invalid @enderror" dir="ltr">
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
                    <h5 class="m-0">Message User Login</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="message_template">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">message template</label>
                            <textarea name="settings[user_login]" class="editor form-control" rows="5">{{ old('user_login',$items['user_login'] ?? '') }}</textarea>
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
                    <h5 class="m-0">Message Doctor Login</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="message_template">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">message template</label>
                            <textarea name="settings[doctor_login]" class="editor form-control" rows="5">{{ old('doctor_login',$items['doctor_login'] ?? '') }}</textarea>
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
                    <h5 class="m-0">Intro Text FA</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="intro_simple_public">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">message</label>
                            <textarea name="settings[intro_fa]" class="editor form-control" rows="5">{{ old('intro_fa',$items['intro_fa'] ?? '') }}</textarea>
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
                    <h5 class="m-0">Intro Text EN</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="intro_simple_public">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">message</label>
                            <textarea name="settings[intro_en]" class="editor form-control" rows="5">{{ old('intro_en',$items['intro_en'] ?? '') }}</textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Map</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="map">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Api Url</label>
                            <input type="text" value="{{ old('api_map',isset($items['api_map']) ? $items['api_map'] : 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw') }}" name="settings[api_map]" class="form-control @error('api_map') is-invalid @enderror">
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
