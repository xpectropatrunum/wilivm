@extends('admin.layouts.master')

@section('title', 'create new clinic')

@section('content_header')
    <style>
        .input-group-text {
            min-width: 70px;
        }
    </style>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create new clinic</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.locations.clinics.index') }}">List clinics</a></li>
                <li class="breadcrumb-item active">Create new clinic</li>
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
                <form action="{{ route('admin.locations.clinics.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content card-body" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-basic-home" role="tabpanel"
                            aria-labelledby="custom-tabs-basic-tab">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>name</label>
                                    <input type="text" value="{{ old('name') }}" name="name"
                                        class="form-control @error('name') is-invalid @enderror" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>clinic id</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="basic-addon1">{{ config('global.prefix_clinic_id') }}</span>
                                        </div>
                                        <input type="text" name="clinic_id" value="{{ old('clinic_id') }}"
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
                                        @foreach ($languages as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('lang') == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <hr class="w-100">
                                <div class="form-group col-12 col-lg-6">
                                    <label>about</label>
                                    <textarea name="about" class="editor form-control @error('about') is-invalid @enderror" rows="4">{{ old('about') }}</textarea>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label>services</label>
                                    <textarea name="services" class="editor form-control @error('services') is-invalid @enderror" rows="4">{{ old('services') }}</textarea>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label>slogan</label>
                                    <textarea name="slogan" class="editor form-control @error('slogan') is-invalid @enderror" rows="4">{{ old('slogan') }}</textarea>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label>business hours</label>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Mon </span>
                                        </div>
                                        <input type="text" value="{{ old('bt.mon') }}" name="bt[mon]"
                                            class="form-control @error('bt.mon') is-invalid @enderror" placeholder="Monday">
                                    </div>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Tue </span>
                                        </div>
                                        <input type="text" value="{{ old('bt.tue') }}" name="bt[tue]"
                                            class="form-control @error('bt.tue') is-invalid @enderror"
                                            placeholder="Tuesday">
                                    </div>

                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Wed </span>
                                        </div>
                                        <input type="text" value="{{ old('bt.wed') }}" name="bt[wed]"
                                            class="form-control @error('bt.wed') is-invalid @enderror"
                                            placeholder="Wednesday">
                                    </div>

                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Thu </span>
                                        </div>
                                        <input type="text" value="{{ old('bt.thu') }}" name="bt[thu]"
                                            class="form-control @error('bt.thu') is-invalid @enderror"
                                            placeholder="Thurseday">
                                    </div>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fri </span>
                                        </div>
                                        <input type="text" value="{{ old('bt.fri') }}" name="bt[fri]"
                                            class="form-control @error('bt.fri') is-invalid @enderror"
                                            placeholder="Friday">
                                    </div>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Sat </span>
                                        </div>
                                        <input type="text" value="{{ old('bt.sat') }}" name="bt[sat]"
                                            class="form-control @error('bt.sat') is-invalid @enderror"
                                            placeholder="Saturday">
                                    </div>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Sun </span>
                                        </div>
                                        <input type="text" value="{{ old('bt.sun') }}" name="bt[sun]"
                                            class="form-control @error('bt.sun') is-invalid @enderror"
                                            placeholder="Sunday">
                                    </div>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label>email</label>
                                    <input type="email" value="{{ old('email') }}" name="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>phone</label>
                                    <input type="tel" value="{{ old('tel') }}" name="tel"
                                        class="form-control @error('tel') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>website</label>
                                    <input type="website" value="{{ old('website') }}" name="website"
                                        class="form-control @error('website') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>telegram</label>
                                    <input type="telegram" value="{{ old('telegram') }}" name="telegram"
                                        class="form-control @error('telegram') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>whatsapp</label>
                                    <input type="whatsapp" value="{{ old('whatsapp') }}" name="whatsapp"
                                        class="form-control @error('whatsapp') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>instagram</label>
                                    <input type="instagram" value="{{ old('instagram') }}" name="instagram"
                                        class="form-control @error('instagram') is-invalid @enderror">
                                </div>

                                <hr class="w-100">


                                <div class="form-group col-lg-4">
                                    <label>country</label>
                                    <select name="address[country_id]" class="form-control select2" required>
                                        <option></option>
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('address.country_id') == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label>state</label>
                                    <select name="address[state_id]" class="form-control select2" required>

                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>city</label>
                                    <select name="address[city_id]" class="form-control select2" required>


                                    </select>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label>address</label>
                                    <input type="address" value="{{ old('address.address') }}" name="address[address]"
                                        class="form-control @error('address.address') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>zip code</label>
                                    <input type="zip_code" value="{{ old('address.zip_code') }}"
                                        name="address[zip_code]"
                                        class="form-control @error('address.zip_code') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>phone</label>
                                    <input type="phone" value="{{ old('address.phone') }}" name="address[phone]"
                                        class="form-control @error('address.phone') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>lat</label>
                                    <input type="lat" value="{{ old('address.lat') }}" name="address[lat]"
                                        class="form-control @error('address.lat') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>lng</label>
                                    <input type="lng" value="{{ old('address.lng') }}" name="address[lng]"
                                        class="form-control @error('address.lng') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>direction</label>
                                    <input type="direction" value="{{ old('address.direction') }}"
                                        name="address[direction]"
                                        class="form-control @error('address.direction') is-invalid @enderror">
                                </div>
                                <hr class="w-100">
                                <div class="form-group col-lg-4">
                                    <label>doctors</label>
                                    <select name="doctors[]" class="form-control select2" multiple>
                                        <option></option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                @if (old('doctor_id') == $doctor->id) selected @endif>Dr.
                                                {{ $doctor->user->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-lg-8">
                                    <label>note</label>
                                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="4">{{ old('note') }}</textarea>
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
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.en.js') }}"></script>
    <script>
        $(function() {

            $last_country = '{{ old('address.country_id') ?? 0 }}';
            $last_state = '{{ old('address.state_id') ?? 0 }}';
            $last_city = '{{ old('address.city_id') ?? 0 }}';
            if ($last_country > 0) {
                $.ajax({
                    url: '{{ route('global.getStates') }}',
                    type: 'get',
                    data: {
                        'id': $last_country,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        $('select[name="address[state_id]"]').html('').html(res).val($last_state);
                        $.ajax({
                            url: '{{ route('global.getCities') }}',
                            type: 'get',
                            data: {
                                'id': $last_state,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(res) {
                                $('select[name="address[city_id]"]').html('').html(res).val(
                                    $last_city);
                            }
                        });
                    }
                });
            }

            $('select[name="address[country_id]"]').on('change', function() {
                var id = $(this).val();

                $.ajax({
                    url: '{{ route('global.getStates') }}',
                    type: 'get',
                    data: {
                        'id': id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        $('select[name="address[state_id]"]').html('').html(res);
                    }
                });
            });

            $('select[name="address[state_id]"]').on('change', function() {
                var id = $(this).val();

                $.ajax({
                    url: '{{ route('global.getCities') }}',
                    type: 'get',
                    data: {
                        'id': id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        $('select[name="address[city_id]"]').html('').html(res);
                    }
                });
            });
        });

        function generateSerial() {
            $.ajax({
                url: '{{ route('admin.locations.clinics.generate-cl-id') }}',
                type: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    $('input[name="clinic_id"]').val(res);
                }
            });
        }
        $(".btn-add-new-image").on("click", function() {
            html = $("#template-image-gallery-item").html();

            $(".table-image-gallery .tbody").append(html);

            $('[data-toggle="tooltip"]').tooltip();


            bsCustomFileInput.init()
        });
        $(document).on("click", ".btn-remove-file", function() {
            id = $(this).closest('form').find('input[name="id"]').val();
            elem = $(this);

            if (id.length) {

                elem.closest(".tr").fadeOut(function() {
                    elem.remove();
                });

            } else {
                elem.closest(".tr").fadeOut(function() {
                    elem.remove();
                });
            }
        });
    </script>
@endpush
