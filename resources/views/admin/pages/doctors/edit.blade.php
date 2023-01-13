@extends('admin.layouts.master')

@section('title', 'edit doctor')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">edit doctor</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">all doctors</a></li>
                <li class="breadcrumb-item active">edit doctor</li>
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
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-reason-tab" data-toggle="pill" href="#custom-reasons"
                                role="tab" aria-controls="custom-reasons" aria-selected="false">Visit Reasons</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-schedules-tab" data-toggle="pill" href="#custom-schedules"
                                role="tab" aria-controls="custom-schedules" aria-selected="false">Visit Schedules</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-translate-tab" data-toggle="pill" href="#custom-translate"
                                role="tab" aria-controls="custom-translate" aria-selected="false">Field Alt</a>
                        </li>


                    </ul>
                </div>
                <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                        <input type="text" name="doctor_id"
                                            value="{{ old('doctor_id', $doctor->doctor_id) }}" class="form-control"
                                            required>
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
                                                @if ($doctor->doctor_language()->where(['language_id' => $item->id])->first()) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>minimum age to visit</label>
                                    <input type="number" value="{{ old('min_age_to_visit', $doctor->min_age_to_visit) }}"
                                        name="min_age_to_visit"
                                        class="form-control @error('min_age_to_visit') is-invalid @enderror" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>alt language</label>
                                    <select name="alt_language" class="form-control select2" required>
                                        <option></option>
                                        @foreach ($languages as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('alt_language', $doctor->alt_language) == $item->id) selected @endif>{{ $item->name }}
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
                                                @if (old('specialty_id', $doctor->specialty_id) == $item->id) selected @endif>{{ $item->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>exprience</label>
                                    <input type="number" value="{{ old('exprience', $doctor->exprience) }}"
                                        name="exprience" class="form-control @error('exprience') is-invalid @enderror"
                                        required>
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
                                    <img src="{{ asset($doctor->media()->where('type', 'image')->first()?->url) }}"
                                        class="img-fluid img-rounded pic-preview bg-light object-fit-cover" width="250"
                                        height="250">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>video</label>
                                    <input type="hidden" name="video" value="">
                                    <div class="custom-file mb-2">
                                        <input type="file" name="video" class="custom-file-input" id="customFile3">
                                        <label class="custom-file-label" for="customFile3">Choose file</label>
                                    </div>
                                    <video width="250" height="250" controls>
                                        <source
                                            src="{{ asset($doctor->media()->where('type', 'video')->first()?->url) }}">

                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                <hr class="w-100">

                                <div class="form-group col-12 col-lg-6">
                                    <label>about</label>
                                    <textarea name="about" class="editor form-control @error('about') is-invalid @enderror" rows="4">{{ old('about', $doctor->about) }}</textarea>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label>note</label>
                                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="4">{{ old('note', $doctor->note) }}</textarea>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>user</label>
                                    <select name="user_id" class="form-control select2" required>
                                        <option></option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('user_id', $doctor->user_id) == $item->id) selected @endif>{{ $item->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>




                                <div class="form-group col-lg-3">
                                    <label>active</label>
                                    <div class="form-check">
                                        <input type="checkbox" name="enable" class="form-check-input" value="1"
                                            id="exampleCheck2" @if (old('enable', $doctor->enable)) checked @endif>
                                        <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-reasons" role="tabpanel"
                            aria-labelledby="custom-tabs-basic-tab">
                            <p>note: The doctor should place in a clinic to create "In-Person Visit" reason.
                            </p>
                            <button type="button" class="btn btn-outline-info btn-add-new-reason mb-4"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-plus-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                                </svg> Add new</button>
                            <div class="table-image-reason px-3">
                                <div class="row mb-3 pb-1 border-bottom">
                                    <div class="col-lg-4">Title</div>
                                    <div class="col-lg-4">Alt</div>
                                    <div class="col-lg-2">Type</div>
                                    <div class="col-lg-2">Action</div>
                                </div>

                                <div class="tbody">
                                    @foreach ($doctor->visit_reasons as $item)
                                        <div class="frmSaveFile tr mb-4">
                                            <input type="hidden" name="reasons[id][]" value="{{ $item->id }}">
                                            <div class="form-row align-items-center">
                                                <div class="col-lg-4">
                                                    <input type="text" value="{{ $item->title }}"
                                                        name="reasons[title][]" class="form-control" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="text"
                                                        value="{{ $item->alt_fields->where('key', 'title')->first()?->value }}"
                                                        name="reasons[alt_title][]" class="form-control">
                                                </div>

                                                <div class="col-lg-2">
                                                    <select name="reasons[type][]" class="form-control " required>


                                                        <option value="1"
                                                            @if (!$doctor->hasClinic) disabled @endif
                                                            @if ($item->type == 1) selected @endif> In-Person
                                                            Visit
                                                        </option>
                                                        <option value="2"
                                                            @if ($item->type == 2) selected @endif> Video Visit
                                                        </option>
                                                        <option value="3"
                                                            @if (!$doctor->hasClinic) disabled @endif
                                                            @if ($item->type == 3) selected @endif> Both
                                                        </option>

                                                    </select>

                                                </div>

                                                <div class="col-lg-2">

                                                    <button type="button"
                                                        class="btn btn-danger btn-sm btn-remove-reason">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-trash"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                            <path fill-rule="evenodd"
                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <template id="template-image-reason-item">

                                <div class="frmSaveFile tr mb-4">
                                    <input type="hidden" name="id" value="">
                                    <div class="form-row align-items-center">
                                        <div class="col-lg-4">
                                            <input type="text" name="reasons[title][]" class="form-control" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" name="reasons[alt_title][]" class="form-control">
                                        </div>

                                        <div class="col-lg-2">
                                            <select name="reasons[type][]" class="form-control " required>

                                                <option value="1" @if (!$doctor->hasClinic) disabled @endif>
                                                    In-Person Visit
                                                </option>
                                                <option value="2">Video Visit
                                                </option>
                                                <option value="3"
                                                @if (!$doctor->hasClinic) disabled @endif
                                               > Both
                                            </option>

                                            </select>

                                        </div>
                                        <div class="col-lg-2">

                                            <button type="button" class="btn btn-danger btn-sm btn-remove-reason">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd"
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </template>
                        </div>
                        <div class="tab-pane fade" id="custom-schedules" role="tabpanel"
                            aria-labelledby="custom-tabs-basic-tab">
                            <div class="row date-container mb-2" style="display: none">

                            </div>

                            <div class="px-3">
                                <div class="row mb-3 pb-1 border-bottom">
                                    <div class="col-lg-4">Title</div>
                                    <div class="col-lg-4">Alt</div>
                                    <div class="col-lg-2">Type</div>
                                    <div class="col-lg-2">Action</div>
                                </div>

                                <div class="tbody">
                                    @foreach ($doctor->visit_reasons as $item)
                                        <div class="frmSaveFile tr mb-4">
                                            <input type="hidden" name="id" value="">
                                            <div class="form-row align-items-center">
                                                <div class="col-lg-4">
                                                    {{ $item->title }}
                                                </div>
                                                <div class="col-lg-4">
                                                    {{ $item->alt_fields->where('key', 'title')->first()?->value }}
                                                </div>

                                                <div class="col-lg-2">


                                                    @if ($item->type == 1)
                                                        In-Person
                                                        Visit
                                                    @else
                                                        Video Visit
                                                    @endif



                                                </div>

                                                <div class="col-lg-2">

                                                    <button type="button" class="btn btn-info btn-sm btn-add-schedule"
                                                        cs="{{ $item->id }}">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>



                        </div>
                        <div class="tab-pane fade " id="custom-translate" role="tabpanel"
                            aria-labelledby="custom-tabs-basic-tab">
                            <div class="row">

                                <div class="form-group col-12 col-lg-6">
                                    <label>about</label>
                                    <textarea name="alt[about]" class="editor form-control @error('alt.about') is-invalid @enderror" rows="4">{{ old('alt.about', $doctor->alt_fields->where('key', 'about')->first()?->value) }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>
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
        loop()

        function loop() {
            $(".btn-add-schedule").on("click", async function() {
                $(".date-container").html("")
                data = await $.get("/admin/visit-schedule/get/" + $(this).attr("cs") + "/{{ $doctor->id }}");
                $(".date-container").html(data).show()
                $('.datepicker').datepicker({
                    language: 'en',
                    timepicker: false,
                    dateFormat: "yy-mm-dd",
                    timeFormat: "hh:ii",
                    autoClose: true
                });
                $(".btn-add-new-schedule").click(function() {
                    $(".date-container").append(temp(this))
                    $('.datepicker').datepicker({
                        language: 'en',
                        timepicker: false,
                        dateFormat: "yy-mm-dd",
                        timeFormat: "hh:ii",
                        autoClose: true
                    });
                    reloop()
                })
                reloop()
            });
        }

        function reloop() {
            $(".create-schedule").on("click", async function() {
                req = await $.post($(this).attr("data-url"),
                    $(this).parent().parent().find('select, textarea, input').serialize()
                )
                if (req.success) {
                    Toast.fire({
                        icon: 'success',
                        'title': "The schedule was created successfully"
                    })
                    //$(".date-container").html("")
                    data = await $.get("/admin/visit-schedule/get/" + req.id + "/{{ $doctor->id }}");
                    $(".date-container").html(data).show()
                    $('.datepicker').datepicker({
                        language: 'en',
                        timepicker: false,
                        dateFormat: "yy-mm-dd",
                        timeFormat: "hh:ii",
                        autoClose: true
                    });
                    $(".btn-add-new-schedule").click(function() {
                        $(".date-container").append(temp(this))
                        $('.datepicker').datepicker({
                            language: 'en',
                            timepicker: false,
                            dateFormat: "yy-mm-dd",
                            timeFormat: "hh:ii",
                            autoClose: true
                        });
                        reloop()
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        'title': req.msg
                    })
                }
            });
        }
        $(".btn-add-new-reason").on("click", function() {
            html = $("#template-image-reason-item").html();
            $(".table-image-reason .tbody").append(html);
            $('[data-toggle="tooltip"]').tooltip();
            bsCustomFileInput.init()
        });
        async function removeSchedule(id) {
            data = await $.get("/admin/visit-schedule/delete/" + id);
            if (data.success) {
                Toast.fire({
                    icon: 'success',
                    'title': "The schedule was deleted successfully"
                })
                $(".date-container").html("")
                data = await $.get("/admin/visit-schedule/get/" + req.id + "/{{ $doctor->id }}");
                $(".date-container").html(data).show()
                $('.datepicker').datepicker({
                    language: 'en',
                    timepicker: false,
                    dateFormat: "yy-mm-dd",
                    timeFormat: "hh:ii",
                    autoClose: true
                });
                $(".btn-add-new-schedule").click(function() {
                    $(".date-container").append(temp(this))
                    $('.datepicker').datepicker({
                        language: 'en',
                        timepicker: false,
                        dateFormat: "yy-mm-dd",
                        timeFormat: "hh:ii",
                        autoClose: true
                    });
                    reloop()
                })
                reloop()
            }
        }
        $(document).on("click", ".btn-remove-reason", function() {
            id = $(this).closest('form').find('input[name="id"]').val();
            elem = $(this);
            if (id.length) {
                elem.closest(".tr").fadeOut(function() {
                    elem.parent().parent().parent().remove();
                });
            } else {
                elem.closest(".tr").fadeOut(function() {
                    elem.parent().parent().parent().remove();
                });
            }
        });
        let temp = (a) => {
            return `<div class="d-flex col-12">
                {{ csrf_field() }}
                <div class="form-group col-lg-2">
                    <label>Price</label>
                    <input type="number" class="form-control"
                        name="price" >
                </div>
                <div class="form-group col-lg-2">
                    <label>Date</label>
                    <input type="text" autocomplete="off"  class="form-control datepicker"
                        name="date" >
                </div>
                <div class="form-group col-lg-2">
                    <label>Time</label>
                    <input type="text" class="form-control" placeholder="00:00" name="from" >
                </div>
        <input name="doctor_id" type="hidden" value="{{ $doctor->id }}" >
                
                <div class="form-group col-lg-6" style="align-self: end;">
                    <button  type="button" data-url="/admin/visit-schedule/create/${$(a).attr("cs")}" class="form-control col-6 btn-success btn btn-create  create-schedule" style="margin-top:21px">
                        Submit
                    </button>
                </div>
            </div>`
        }
    </script>
@endpush
