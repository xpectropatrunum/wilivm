@extends('admin.layouts.master')

@section('title', 'background settings')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Background Settings</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">background settings</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Background Default Pages</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="background">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>desktop</label>
                                <input type="hidden" name="settings[background_default_page][desktop]" value="{{ $items['background_default_page']['desktop'] ?? '' }}">
                                <div class="custom-file mb-2">
                                    <input type="file" name="settings[background_default_page][desktop]" onchange="readURL(this)" class="custom-file-input" id="customFile2">
                                    <label class="custom-file-label" for="customFile2">{{ $items['background_default_page']['desktop'] ?? 'Choose file' }}</label>
                                </div>
                                <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" @if(!empty($items['background_default_page']['desktop'])) src="{{ asset($items['background_default_page']['desktop']) }}" @endif width="150" height="150">
                            </div>

                            <div class="form-group col-lg-6">
                                <label>mobile</label>
                                <input type="hidden" name="settings[background_default_page][mobile]" value="{{ $items['background_default_page']['mobile'] ?? '' }}">
                                <div class="custom-file mb-2">
                                    <input type="file" name="settings[background_default_page][mobile]" onchange="readURL(this)" class="custom-file-input" id="customFile1">
                                    <label class="custom-file-label" for="customFile1">{{ $items['background_default_page']['mobile'] ?? 'Choose file' }}</label>
                                </div>
                                <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" @if(!empty($items['background_default_page']['mobile'])) src="{{ asset($items['background_default_page']['mobile']) }}" @endif width="150" height="150">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>

        {{--  <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Background items info popup</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="background">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>about</label>
                                <input type="hidden" name="settings[modal_info][about]" value="{{ $items['modal_info']['about'] ?? '' }}">
                                <div class="custom-file mb-2">
                                    <input type="file" name="settings[modal_info][about]" onchange="readURL(this)" class="custom-file-input" id="customFile2">
                                    <label class="custom-file-label" for="customFile2">{{ $items['modal_info']['about'] ?? 'Choose file' }}</label>
                                </div>
                                <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" @if(!empty($items['modal_info']['about'])) src="{{ asset($items['modal_info']['about']) }}" @endif width="150" height="150">
                            </div>

                            <div class="form-group col-lg-4">
                                <label>faq</label>
                                <input type="hidden" name="settings[modal_info][faq]" value="{{ $items['modal_info']['faq'] ?? '' }}">
                                <div class="custom-file mb-2">
                                    <input type="file" name="settings[modal_info][faq]" onchange="readURL(this)" class="custom-file-input" id="customFile1">
                                    <label class="custom-file-label" for="customFile1">{{ $items['modal_info']['faq'] ?? 'Choose file' }}</label>
                                </div>
                                <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" @if(!empty($items['modal_info']['faq'])) src="{{ asset($items['modal_info']['faq']) }}" @endif width="150" height="150">
                            </div>

                            <div class="form-group col-lg-4">
                                <label>stores</label>
                                <input type="hidden" name="settings[modal_info][stores]" value="{{ $items['modal_info']['stores'] ?? '' }}">
                                <div class="custom-file mb-2">
                                    <input type="file" name="settings[modal_info][stores]" onchange="readURL(this)" class="custom-file-input" id="customFile1">
                                    <label class="custom-file-label" for="customFile1">{{ $items['modal_info']['stores'] ?? 'Choose file' }}</label>
                                </div>
                                <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" @if(!empty($items['modal_info']['stores'])) src="{{ asset($items['modal_info']['stores']) }}" @endif width="150" height="150">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>  --}}

        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Background Maintenance Page</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="background">
                    <div class="card-body">
                        <div class="form-group">
                            <label>desktop</label>
                            <input type="hidden" name="settings[maintenance_background]" value="{{ $items['maintenance_background'] ?? '' }}">
                            <div class="custom-file mb-2">
                                <input type="file" name="settings[maintenance_background]" onchange="readURL(this)" class="custom-file-input" id="customFileMaintenance">
                                <label class="custom-file-label" for="customFileMaintenance">{{ $items['maintenance_background'] ?? 'Choose file' }}</label>
                            </div>
                            <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" @if(!empty($items['maintenance_background'])) src="{{ asset($items['maintenance_background']) }}" @endif width="150" height="150">
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
