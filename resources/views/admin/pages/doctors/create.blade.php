@extends('admin.layouts.master')

@section('title', 'create new doctor')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">create new doctor</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">all doctors</a></li>
                <li class="breadcrumb-item active">create new doctor</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-basic-tab" data-toggle="pill"
                                href="#custom-basic-home" role="tab" aria-controls="custom-basic-home"
                                aria-selected="true">Basic Info</a>
                        </li>



                       
                    </ul>
                </div>
                <form action="{{ route('admin.doctors.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content card-body" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-basic-home" role="tabpanel"
                            aria-labelledby="custom-tabs-basic-tab">
                            <div class="row">

                                <div class="form-group col-lg-4">
                                    <label>dr id</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="basic-addon1">{{ config('global.prefix_doctor_id') }}</span>
                                        </div>
                                        <input type="text" name="doctor_id" value="{{ old('doctor_id') }}"
                                            class="form-control" required>
                                        <div class="input-group-append" id="button-addon4">
                                            <button class="btn btn-outline-secondary" data-toggle="tooltip"
                                                data-placement="right" title="Generate ID" type="button"
                                                onclick="generateSerial()"><i class="fa fa-bolt"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>vocal languages</label>
                                    <select name="langs[]" class="form-control select2" multiple required>
                                        @foreach ($vocalLanguages as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('lang') == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>minimum age to visit</label>
                                    <input type="number" value="{{ old('min_age_to_visit') }}" name="min_age_to_visit"
                                        class="form-control @error('min_age_to_visit') is-invalid @enderror" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>alt language</label>
                                    <select name="alt_language" class="form-control select2" required>
                                        <option></option>
                                        @foreach ($languages  as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('alt_language') == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>specialty</label>
                                    <select name="specialty_id" class="form-control select2" required>
                                        <option></option>
                                        @foreach ($specialties as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('specialty_id') == $item->id) selected @endif>{{ $item->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>exprience</label>
                                    <input type="number" value="{{ old('exprience') }}" name="exprience"
                                        class="form-control @error('exprience') is-invalid @enderror" required>
                                </div>
                                <hr class="w-100">
                                <div class="form-group col-lg-6">
                                    <label>image</label>
                                    <input type="hidden" name="image" value="">
                                    <div class="custom-file mb-2">
                                        <input type="file" name="image" onchange="readURL(this)"
                                            class="custom-file-input" id="customFile2">
                                        <label class="custom-file-label" for="customFile2">Choose file</label>
                                    </div>
                                    <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" width="150"
                                        height="150">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>video</label>
                                    <input type="hidden" name="video" value="">
                                    <div class="custom-file mb-2">
                                        <input type="file" name="video"
                                            class="custom-file-input" id="customFile3">
                                        <label class="custom-file-label" for="customFile3">Choose file</label>
                                    </div>
                                   
                                </div>
                                <hr class="w-100">

                                <div class="form-group col-12 col-lg-6">
                                    <label>about</label>
                                    <textarea name="about" class="editor form-control @error('about') is-invalid @enderror" rows="4">{{ old('about') }}</textarea>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label>note</label>
                                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="4">{{ old('note') }}</textarea>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>user</label>
                                    <select name="user_id" class="form-control select2" required>
                                        <option></option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('user_id') == $item->id) selected @endif>{{ $item->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                              


                                <div class="form-group col-lg-3">
                                    <label>active</label>
                                    <div class="form-check">
                                        <input type="checkbox" name="enable" class="form-check-input" value="1"
                                            id="exampleCheck2" @if (old('enable')) checked @endif>
                                        <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    
                    </div>



                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                    </div>

                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
    <link id="jquiCSS" rel="stylesheet"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" type="text/css"
        media="all">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/colorpicker/colorpicker.min.css') }}">
@endpush

@push('admin_js')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <script src="{{ asset('admin-panel/libs/colorpicker/colorpicker.min.js') }}"></script>
    <script>
    
            function generateSerial() {
                $.ajax({
                    url: '{{ route('admin.locations.clinics.generate-cl-id') }}',
                    type: 'get',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        $('input[name="doctor_id"]').val(res);
                    }
                });
            }
       
            
  
    </script>
@endpush
