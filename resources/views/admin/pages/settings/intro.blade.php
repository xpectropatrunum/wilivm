@extends('admin.layouts.master')

@section('title', 'intro info')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Intro Info</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">intro page</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Intro Info</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="intro">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Text:</label>

                                <textarea name="settings[intro][text]" class="form-control editor">{{ old('settings[intro][text]',$items['intro']['text'] ?? '') }}</textarea>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>background desktop</label>
                                <div class="custom-file mb-2">
                                    @if(!empty($items['intro']['desktop']))
                                        <input type="hidden" name="settings[intro][desktop]" value="{{ $items['intro']['desktop'] }}">
                                    @endif

                                    <input type="file" name="settings[intro][desktop]" onchange="readURL(this)" class="custom-file-input" id="customFile2">
                                    <label class="custom-file-label" for="customFile2">Choose file</label>
                                </div>
                                <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" @if(!empty($items['intro']['desktop'])) src="{{ asset($items['intro']['desktop']) }}" @endif width="150" height="150" alt="">
                            </div>

                            <div class="form-group col-lg-6">
                                <label>background mobile</label>
                                <div class="custom-file mb-2">
                                    @if(!empty($items['intro']['mobile']))
                                        <input type="hidden" name="settings[intro][mobile]" value="{{ $items['intro']['mobile'] }}">
                                    @endif
                                    <input type="file" name="settings[intro][mobile]" onchange="readURL(this)" class="custom-file-input" id="customFile1">
                                    <label class="custom-file-label" for="customFile1">Choose file</label>
                                </div>
                                <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" @if(!empty($items['intro']['mobile'])) src="{{ asset($items['intro']['mobile']) }}" @endif width="150" height="150" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer text-center">
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
