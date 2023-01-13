@extends('admin.layouts.master')

@section('title', 'create new page')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create new page</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">List pages</a></li>
                <li class="breadcrumb-item active">Create new page</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create new page</h3>
                </div>
                <form action="{{ route('admin.pages.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>title page</label>
                                <input type="text" value="{{ old('title') }}" name="title" class="form-control @error('title') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>slug</label>
                                <input type="text" value="{{ old('slug') }}" name="slug" class="form-control @error('slug') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-12">
                                <label>content</label>
                                <textarea name="content" class="editor form-control @error('content') is-invalid @enderror" rows="10">{{ old('content') }}</textarea>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-6">
                                <label>meta title</label>
                                <input type="text" value="{{ old('meta_title') }}" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>meta description</label>
                                <input type="text" value="{{ old('meta_description') }}" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror">
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-5">
                                <label>background desktop</label>
                                <div class="custom-file mb-2">
                                    <input type="file" name="background[desktop]" onchange="readURL(this)" class="custom-file-input" id="customFile2">
                                    <label class="custom-file-label" for="customFile2">Choose file</label>
                                </div>
                                <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" width="150" height="150" alt="">
                            </div>

                            <div class="form-group col-lg-5">
                                <label>background mobile</label>
                                <div class="custom-file mb-2">
                                    <input type="file" name="background[mobile]" onchange="readURL(this)" class="custom-file-input" id="customFile1">
                                    <label class="custom-file-label" for="customFile1">Choose file</label>
                                </div>
                                <img class="img-fluid img-rounded pic-preview bg-light object-fit-cover" width="150" height="150" alt="">
                            </div>

                            {{--  <div class="form-group col-lg-2">
                                <label>Has shadow?</label>
                                <div class="form-check">
                                    <input type="checkbox" name="has_shadow" class="form-check-input" value="1" id="aaa" {{ old('has_shadow') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="aaa"> Yes</label>
                                </div>
                            </div>  --}}
                            <div class="w-100"></div>
                            <div class="form-group col-lg-6">
                                <label>enable</label>
                                <div class="form-check">
                                    <input type="checkbox" name="enable" class="form-check-input" value="1" id="exampleCheck1" {{ old('enable') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1"> Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

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

@endpush

@push('admin_js')
    <script>
        $(function () {

        })
    </script>
@endpush
