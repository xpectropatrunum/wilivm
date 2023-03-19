@extends('admin.layouts.master')

@section('title', 'Send message')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Send message</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.bulletins.index') }}">Bulletin</a></li>
                <li class="breadcrumb-item active">Send message</li>
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
                    <h3 class="card-title">Send message</h3>
                </div>
                <form action="{{ route('admin.bulletins.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                       

                          
                       
                            <div class="form-group col-lg-12">
                                <label>message</label>
                                <textarea name="message" class="form-control editor" rows="10"></textarea>
                               
                            </div>
                            
        
                        </div>
                    </div>

                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">Send</button>
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
