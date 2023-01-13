@extends('admin.layouts.master')

@section('title', 'create new specialty')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">create new specialty</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.specialties.index') }}">all specialties</a></li>
                <li class="breadcrumb-item active">create new specialty</li>
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
                               aria-selected="true">basic info</a>
                        </li>
                     
                    </ul>
                </div>

                <form action="{{ route('admin.specialties.store') }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf



                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-basic-home" role="tabpanel"
                                 aria-labelledby="custom-tabs-basic-tab">
                              
                                    
                                    <div class="form-group col-lg-4">
                                        <label>title</label>
                                        <input type="text" value="{{ old('title') }}" name="title"
                                            class="form-control @error('title') is-invalid @enderror" placeholder="" required>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>parent</label>
                                        <select name="parent_id" class="form-control select2">
                                            <option></option>
                                            @foreach ($parents as $parent)
                                                <option value="{{ $parent->id }}" @if ($parent->id == old('parent_id')) selected @endif>
                                                    {{ $parent->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-100"></div>
                
                
                                    <div class="form-group col-lg-6">
                                        <label>description</label>
                                        <input type="text" value="{{ old('description') }}" name="description"
                                            class="form-control @error('description') is-invalid @enderror">
                                    </div>
                
                                    <div class="form-group col-lg-3">
                                        <label>active</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="enable" class="form-check-input" value="1" id="exampleCheck2" @if(old('enable')) checked @endif>
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
            </div>
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
        $(function() {
            $('.color-picker').colorpicker();

            var counter = 0;
            $(".btn-plus").on("click", function() {
                var html = $(".template-tag-warning").html();

                html = html.replace(/{ID}/g, counter++);

                $(".table-tag-warning tbody").append(html);
            });

            $(document).on("click", ".btn-remove-tag", function() {
                $(this).closest("tr").fadeOut(function() {
                    $(this).remove();
                });
            });

            $('.warning-items input,.warning-items textarea,.warning-items select').prop('disabled', true);
            $('#enable-content-warning').on('click', function() {
                if ($(this).is(':checked')) {
                    $('.warning-items input,.warning-items textarea,.warning-items select').prop('disabled',
                        false);
                    $('.warning-items').slideDown();
                    CKEDITOR.instances['content_warning[description]'].setReadOnly(false);
                } else {
                    $('.warning-items input,.warning-items textarea,.warning-items select').prop('disabled',
                        true);
                    $('.warning-items').slideUp();
                    CKEDITOR.instances['content_warning[description]'].setReadOnly(true);
                }
            });
        });
    </script>
@endpush
