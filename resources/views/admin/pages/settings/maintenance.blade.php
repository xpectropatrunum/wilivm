@extends('admin.layouts.master')

@section('title', 'maintenance mode')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">maintenance mode</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">maintenance mode</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Maintenance inforamtion</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="maintenance">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>Maintenance Page DateTime:</label>

                                <input type="text" id="datepicker-maintenance" class="form-control" name="settings[maintenance][datetime]" value="{{ old('settings[maintenance][datetime]',$items['maintenance']['datetime'] ?? '') }}">
                            </div>

                            <div class="form-group col-lg-3">
                                <label>Maintenance Status:</label>

                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" name="settings[maintenance][status]" value="0">
                                        <input type="checkbox" name="settings[maintenance][status]" value="1" @if(old('settings[maintenance][status]',$items['maintenance']['status'] ?? '')) checked @endif> Enable
                                    </label>
                                </div>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>From Time:</label>

                                <input type="text" class="form-control" placeholder="00:00" name="settings[maintenance][hour_from]" value="{{ old('settings[maintenance][hour_from]',$items['maintenance']['hour_from'] ?? '') }}">

                                <small>Example: 00:30</small>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>To Time:</label>

                                <input type="text" class="form-control" placeholder="00:00" name="settings[maintenance][hour_to]" value="{{ old('settings[maintenance][hour_to]',$items['maintenance']['hour_to'] ?? '') }}">

                                <small>Example: 18:00</small>
                            </div>

                            <div class="w-100"></div>

                            <div class="form-group col-lg-3">
                                <label>Ip: (Seperate with Enter)</label>

                                <textarea name="settings[maintenance][ip]" rows="10" class="form-control">{{ old('settings[maintenance][ip]',$items['maintenance']['ip'] ?? '') }}</textarea>
                            </div>

                            <div class="form-group col-lg-9">
                                <label>Text:</label>

                                <textarea name="settings[maintenance][text]" class="form-control editor">{{ old('settings[maintenance][text]',$items['maintenance']['text'] ?? '') }}</textarea>
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
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.en.js') }}"></script>
    <script>
        $(function () {
            $('#datepicker-maintenance').datepicker({
                language: 'en',
                timepicker: true,
                dateFormat: "yyyy-mm-dd",
                timeFormat: "hh:ii",
                autoClose: true
            });
        });
    </script>
@endpush
