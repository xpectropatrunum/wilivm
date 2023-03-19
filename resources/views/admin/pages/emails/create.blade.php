@extends('admin.layouts.master')

@section('title', 'create new email')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create new email</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.emails.index') }}">List emails</a></li>
                <li class="breadcrumb-item active">Create new email</li>
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
                    <h3 class="card-title">Create new email</h3>
                </div>
                <form action="{{ route('admin.emails.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>Name</label>
                                <input type="text" value="{{ old('name') }}" name="name"
                                    class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Title (email subject)</label>
                                <input type="text" value="{{ old('title') }}" name="title"
                                    class="form-control @error('title') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Head title (box header)</label>
                                <input type="text" value="{{ old('head') }}" name="head"
                                    class="form-control @error('head') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Type</label>
                                <select name="type" class="form-control select2">
                                    @foreach (App\Enums\EEmailType::asSelectArray() as $key => $type)
                                        <option value="{{  $key }}" @if ( $key == old('type')) selected @endif>
                                            {{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                          
                            <div class="form-group col-lg-4">
                                <h6>Usable fileds:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>$user</th>
                                            <td>
                                                first_name ,
                                                last_name ,
                                                email ,
                                                username ,
                                                verification_code ,
                                            </td>
                                        </tr>
                                        {{--  <tr>
                                            <th>$invoice</th>
                                            <td>
                                                first_name ,
                                                last_name ,
                                                email ,
                                                username ,
                                                verification_code ,
                                            </td>
                                        </tr>  --}}

                                    </tbody>
                                </table>

                            </div>
                            <div class="form-group col-lg-8">
                                <textarea name="template" class="form-control editor" rows="10">{{ old('template') }}</textarea>
                                <button type="button" class="btn btn-secondary mt-2 evaluate">Evaluate template</button>


                            </div>
                            <div class="form-group col-lg-4">
                                <label>enable</label>
                                <div class="form-check">
                                    <input type="checkbox" name="enabled" class="form-check-input" value="1"
                                        id="exampleCheck2" @if (old('enabled')) checked @endif>
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-left">
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
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.en.js') }}"></script>
    <script>
        $(".evaluate").click(function() {

            $.ajax({
                url: "{{ route('admin.emails.eval') }}",
                type: 'post',
                data: {
                    'template': CKEDITOR.instances.template.getData(),
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                beforeSend: function() {
                    // $("#beforeAfterLoading").addClass("spinner-border");
                },
                complete: function() {
                    // $("#beforeAfterLoading").removeClass("spinner-border");
                },
                success: function(res) {

                    Swal.fire({
                        title: res.msg,
                    }).then(function(result) {

                    });


                }
            });
        })
    </script>
@endpush
