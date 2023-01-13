@extends('admin.layouts.master')

@section('title', 'edit clinic')

@section('content_header')
    <style>
        .input-group-text {
            min-width: 70px;
        }

        .fade {
            display: none;
        }

        .active {
            display: block;
        }
    </style>
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit clinic</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.locations.clinics.index') }}">List clinics</a></li>
                <li class="breadcrumb-item active">Edit clinic</li>
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
                            <a class="nav-link" id="custom-tabs-gallery-tab" data-toggle="pill" href="#custom-gallery"
                                role="tab" aria-controls="custom-gallery" aria-selected="false">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-translate-tab" data-toggle="pill" href="#custom-translate"
                                role="tab" aria-controls="custom-translate" aria-selected="false">Translates</a>
                        </li>

                    </ul>
                </div>

                <div class="tab-content card-body" id="custom-tabs-four-tabContent">

                    <form action="{{ route('admin.locations.clinics.update', $clinic->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="tab-pane fade show active" id="custom-basic-home" role="tabpanel"
                            aria-labelledby="custom-tabs-basic-tab">

                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>name</label>
                                    <input type="text" value="{{ old('name', $clinic->name) }}" name="name"
                                        class="form-control @error('name') is-invalid @enderror" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>clinic id</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="basic-addon1">{{ config('global.prefix_clinic_id') }}</span>
                                        </div>
                                        <input type="text" name="clinic_id"
                                            value="{{ old('clinic_id', $clinic->clinic_id) }}" class="form-control"
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
                                        @foreach ($languages as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($clinic->languages()->where(['language_id' => $item->id, 'clinic_id' => $clinic->id])->first()) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <hr class="w-100">
                                <div class="form-group col-12 col-lg-6">
                                    <label>about</label>
                                    <textarea name="about" class="editor form-control @error('about') is-invalid @enderror" rows="4">{{ old('about', $clinic->about) }}</textarea>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label>services</label>
                                    <textarea name="services" class="editor form-control @error('services') is-invalid @enderror" rows="4">{{ old('services', $clinic->services) }}</textarea>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label>slogan</label>
                                    <textarea name="slogan" class="editor form-control @error('slogan') is-invalid @enderror" rows="4">{{ old('slogan', $clinic->slogan) }}</textarea>
                                </div>
                                <div class="form-group col-12 col-lg-6">
                                    <label>business hours</label>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Mon </span>
                                        </div>
                                        <input type="text"
                                            value="{{ old('bt.mon',$clinic->business_times()->where('weekday', 'mon')->first()?->time) }}"
                                            name="bt[mon]" class="form-control @error('bt.mon') is-invalid @enderror"
                                            placeholder="Monday">
                                    </div>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Tue </span>
                                        </div>
                                        <input type="text"
                                            value="{{ old('bt.tue',$clinic->business_times()->where('weekday', 'tue')->first()?->time) }}"
                                            name="bt[tue]" class="form-control @error('bt.tue') is-invalid @enderror"
                                            placeholder="Tuesday">
                                    </div>

                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Wed </span>
                                        </div>
                                        <input type="text"
                                            value="{{ old('bt.wed',$clinic->business_times()->where('weekday', 'wed')->first()?->time) }}"
                                            name="bt[wed]" class="form-control @error('bt.wed') is-invalid @enderror"
                                            placeholder="Wednesday">
                                    </div>

                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Thu </span>
                                        </div>
                                        <input type="text"
                                            value="{{ old('bt.thu',$clinic->business_times()->where('weekday', 'thu')->first()?->time) }}"
                                            name="bt[thu]" class="form-control @error('bt.thu') is-invalid @enderror"
                                            placeholder="Thurseday">
                                    </div>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fri </span>
                                        </div>
                                        <input type="text"
                                            value="{{ old('bt.fri',$clinic->business_times()->where('weekday', 'fri')->first()?->time) }}"
                                            name="bt[fri]" class="form-control @error('bt.fri') is-invalid @enderror"
                                            placeholder="Friday">
                                    </div>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Sat </span>
                                        </div>
                                        <input type="text"
                                            value="{{ old('bt.sat',$clinic->business_times()->where('weekday', 'sat')->first()?->time) }}"
                                            name="bt[sat]" class="form-control @error('bt.sat') is-invalid @enderror"
                                            placeholder="Saturday">
                                    </div>
                                    <div class="input-group  mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Sun </span>
                                        </div>
                                        <input type="text"
                                            value="{{ old('bt.sun',$clinic->business_times()->where('weekday', 'sun')->first()?->time) }}"
                                            name="bt[sun]" class="form-control @error('bt.sun') is-invalid @enderror"
                                            placeholder="Sunday">
                                    </div>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label>email</label>
                                    <input type="email" value="{{ old('email', $clinic->email) }}" name="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>phone</label>
                                    <input type="tel" value="{{ old('tel', $clinic->tel) }}" name="tel"
                                        class="form-control @error('tel') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>website</label>
                                    <input type="website" value="{{ old('website', $clinic->website) }}" name="website"
                                        class="form-control @error('website') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>telegram</label>
                                    <input type="telegram" value="{{ old('telegram', $clinic->telegram) }}"
                                        name="telegram" class="form-control @error('telegram') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>whatsapp</label>
                                    <input type="whatsapp" value="{{ old('whatsapp', $clinic->whatsapp) }}"
                                        name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>instagram</label>
                                    <input type="instagram" value="{{ old('instagram', $clinic->instagram) }}"
                                        name="instagram" class="form-control @error('instagram') is-invalid @enderror">
                                </div>

                                <hr class="w-100">


                                <div class="form-group col-lg-4">
                                    <label>country</label>
                                    <select name="address[country_id]" class="form-control select2" required>
                                        <option></option>
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('address.country_id', $clinic->address->country_id) == $item->id) selected @endif>{{ $item->name }}
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
                                    <input type="address" value="{{ old('address.address', $clinic->address->address) }}"
                                        name="address[address]"
                                        class="form-control @error('address.address') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>zip code</label>
                                    <input type="zip_code"
                                        value="{{ old('address.zip_code', $clinic->address->zip_code) }}"
                                        name="address[zip_code]"
                                        class="form-control @error('address.zip_code') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>phone</label>
                                    <input type="phone" value="{{ old('address.phone', $clinic->address->phone) }}"
                                        name="address[phone]"
                                        class="form-control @error('address.phone') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>lat</label>
                                    <input type="lat" value="{{ old('address.lat', $clinic->address->lat) }}"
                                        name="address[lat]"
                                        class="form-control @error('address.lat') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>lng</label>
                                    <input type="lng" value="{{ old('address.lng', $clinic->address->lng) }}"
                                        name="address[lng]"
                                        class="form-control @error('address.lng') is-invalid @enderror">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>direction</label>
                                    <input type="direction"
                                        value="{{ old('address.direction', $clinic->address->direction) }}"
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
                                                @if (collect($clinic->doctor_clinic)->where("doctor_id", $doctor->id)->first()) selected @endif>Dr.
                                                {{ $doctor->user?->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-lg-8">
                                    <label>note</label>
                                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="4">{{ old('note', $clinic->note) }}</textarea>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>active</label>
                                    <div class="form-check">
                                        <input type="checkbox" name="enable" class="form-check-input" value="1"
                                            id="exampleCheck2" @if (old('enable', $clinic->enable)) checked @endif>
                                        <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>


                        </div>
                    
                    </form>
                    
                </div>


                <div class="tab-pane fade" id="custom-translate" role="tabpanel"
                        aria-labelledby="custom-tabs-translate-tab">
                        <button type="button" class="btn btn-outline-info btn-add-new-translate mb-4"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path
                                    d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                            </svg> Add new translate</button>
                        <div class="table-translates px-3">
                            <div class="row mb-3 pb-1 border-bottom">
                                <div class="col-lg-9">Content</div>
                                <div class="col-lg-2">Language</div>
                                <div class="col-lg-1">Action</div>
                            </div>

                            <div class="tbody">
                                @foreach ($clinic->alt_field as $translate)
                                    <form class="frmSaveTranslate tr mb-4">
                                        <input type="hidden" name="id" value="{{ $translate->id }}">
                                        <div class="form-row align-items-center mb-4">
                                            <div class="col-lg-2">
                                                <select name="key" class="form-control">
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type }}"
                                                            @if ($type == $translate->key) selected @endif>
                                                            {{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-7">

                                                <textarea name="value" id="content-{{ $translate->id }}" class="editor-translate form-control">{{ $translate->value }}</textarea>

                                            </div>
                                            <div class="col-lg-2">
                                                <select name="language_id" class="form-control">
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->id }}"
                                                            @if ($language->id == $translate->language_id) selected @endif>
                                                            {{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="submit" class="btn btn-success btn-sm btn-save-translate"
                                                    data-toggle="tooltip" title="Save">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                    </svg>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm btn-remove-translate">
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
                                    </form>
                                @endforeach
                            </div>

                        </div>

                        <template id="template-translate-item">
                            <form class="frmSaveTranslate tr mb-4">
                                <input type="hidden" name="id" value="">
                                <div class="form-row align-items-center mb-4">
                                    <div class="col-lg-2">
                                        <select name="key" class="form-control">
                                            @foreach ($types as $type)
                                                <option value="{{ $type }}">
                                                    {{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-7">


                                        <textarea name="value" id="cont-{ID}" class="editor-translate form-control"></textarea>

                                    </div>
                                    <div class="col-lg-2">
                                        <select name="language_id" class="form-control">
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="submit" class="btn btn-success btn-sm btn-save-translate"
                                            data-toggle="tooltip" title="Save">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                                <path
                                                    d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-remove-translate">
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
                            </form>
                        </template>
                    </div>

                    
                <div class="tab-pane fade" id="custom-gallery" role="tabpanel" aria-labelledby="custom-tabs-gallery-tab">
                    <button type="button" class="btn btn-outline-info btn-add-new-image mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                        </svg> Add new image</button>
                    <div class="table-image-gallery px-3">
                        <div class="row mb-3 pb-1 border-bottom">
                            <div class="col-lg-5">Image</div>
                            <div class="col-lg-3">Use as</div>
                            <div class="col-lg-3">Combination</div>
                            <div class="col-lg-1">Action</div>
                        </div>

                        <div class="tbody">
                            @foreach($product->files as $file)
                                @if($file->use_as != 'default')
                                    <form class="frmSaveFile tr mb-4">
                                        <input type="hidden" name="id" value="{{ $file->id }}">
                                        <div class="form-row align-items-center">
                                            <div class="col-lg-5">
                                                <div class="form-group mb-0 d-flex align-items-center">
                                                    <img
                                                        class="img-fluid img-rounded pic-preview bg-light object-fit-cover mr-2"
                                                        width="60" height="60"
                                                        src="{{ asset($galleryUrl.$product->id.'/gallery/small/'.$file->name) }}">
                                                    <div class="custom-file">
                                                        <input type="hidden" name="name" value="{{ $file->name }}">
                                                        <input type="file" name="image"
                                                               onchange="readURL(this)" class="custom-file-input"
                                                               id="customFileTexture{{ $file->id }}">
                                                        <label class="custom-file-label"
                                                               for="customFileTexture{{ $file->id }}">{{ $file->name }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <select name="use_as" class="form-control select2">
                                                    <option></option>
                                                    @foreach(config('global.file_use_as') as $label=>$val)
                                                        <option value="{{ $label }}"
                                                                @if($label == $file->use_as) selected @endif>{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <select name="variant_id" class="form-control select2">
                                                    <option></option>

                                                    @foreach($product->variants as $variant)
                                                        <option value="{{ $variant->id }}" @if($variant->id == $file->variant_id) selected @endif>{{ json_encode($variant->label) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="submit" class="btn btn-success btn-sm btn-save-file"
                                                        data-toggle="tooltip" title="Save">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                                                    </svg>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm btn-remove-file">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-trash"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path fill-rule="evenodd"
                                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <template id="template-image-gallery-item">
                        <form class="frmSaveFile tr mb-4">
                            <input type="hidden" name="id" value="">
                            <div class="form-row align-items-center">
                                <div class="col-lg-5">
                                    <div class="form-group mb-0 d-flex align-items-center">
                                        <img
                                            class="img-fluid img-rounded pic-preview bg-light object-fit-cover mr-2"
                                            width="60" height="60" alt="">
                                        <div class="custom-file">
                                            <input type="file" name="image"
                                                   onchange="readURL(this)" class="custom-file-input"
                                                   id="customFilegallery">
                                            <label class="custom-file-label" for="customFilegallery">Choose
                                                file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <select name="use_as" class="form-control select2">
                                        <option></option>
                                        @foreach(config('global.file_use_as') as $label=>$val)
                                            <option value="{{ $label }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select name="variant_id" class="form-control select2">
                                        <option></option>
                                        @foreach($product->variants as $variant)
                                            <option value="{{ $variant->id }}">{{ json_encode($variant->label) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-1">
                                    <button type="submit" class="btn btn-success btn-sm btn-save-file"
                                            data-toggle="tooltip" title="Save">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                            <path
                                                d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-remove-file">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd"
                                                  d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </template>
                </div>




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

            $last_country = '{{ old('address.country_id', $clinic->address->country_id) ?? 0 }}';
            $last_state = '{{ old('address.state_id', $clinic->address->state_id) ?? 0 }}';
            $last_city = '{{ old('address.city_id', $clinic->address->city_id) ?? 0 }}';
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
                    elem.parent().parent().parent().remove();
                });

            } else {
                elem.closest(".tr").fadeOut(function() {
                    elem.parent().parent().parent().remove();
                });
            }
        });
        var counterTranslate = $(".table-translates .tbody form").length || 0;
        $(".btn-add-new-translate").on("click", function() {
            html = $("#template-translate-item").html();

            c = counterTranslate++;
            html = html.replace(/{ID}/g, c);

            $(".table-translates .tbody").append(html);

            setTimeout(function() {
                CKEDITOR.replace('cont-' + c, {
                    filebrowserUploadUrl: baseUrl() + "admin/upload-image?_token=" + $(
                        'meta[name="csrf-token"]').attr('content'),
                    filebrowserUploadMethod: 'form'
                });
            }, 100);
        });
        $(document).on("click", ".btn-remove-translate", function() {
            id = $(this).closest('form').find('input[name="id"]').val();
            elem = $(this);

            if (id.length) {
                $.ajax({
                    url: "{{ route('admin.locations.clinics.remove_alt', $clinic->id) }}",
                    type: 'post',
                    data: {
                        'id': id,
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
                        elem.closest(".tr").fadeOut(function() {
                            elem.remove();
                        });
                        Toast.fire({
                            icon: 'success',
                            'title': 'Record remove successfully'
                        })
                    }
                });
            } else {
                elem.closest(".tr").fadeOut(function() {
                    elem.remove();
                });
            }
        });
        $('body').on('submit', '.frmSaveTranslate', function(e) {
            e.preventDefault();
            form = $(this);
            $button = $(this).find('.btn-save-translate');
            data = $(this).serializeArray();
            data.push({
                name: "_token",
                value: "{{ csrf_token() }}"
            });
            $.ajax({
                url: "{{ route('admin.locations.clinics.save_alt', $clinic->id) }}",
                type: 'post',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $button.find(".spinner-border").css('display', 'inline-block');
                },
                complete: function() {
                    $button.find(".spinner-border").hide();
                },
                success: function(res) {
                    if (res.status) {
                        form.find('input[name="id"]').val(res.id);
                        Toast.fire({
                            icon: 'success',
                            'title': res.message
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            'title': res.message
                        })
                    }
                }
            });
        });

        $("#custom-tabs-basic-tab").click(function() {
            $("#custom-translate").removeClass("active").removeClass("show")
        })
        $("#custom-tabs-gallery-tab").click(function() {
            $("#custom-translate").removeClass("active").removeClass("show")
        })
        $("#custom-tabs-translate-tab").click(function() {
            $(".tab-pane").removeClass("active")
            $(".nav-link").removeClass("active")
            $("#custom-translate").addClass("active").addClass("show")
            $(this).addClass("active")
        })
        $('.editor-translate').each(function() {
            CKEDITOR.replace(this.id, {
                filebrowserUploadUrl: baseUrl() + "admin/upload-image?_token=" + $(
                    'meta[name="csrf-token"]').attr('content'),
                filebrowserUploadMethod: 'form'
            });
        });
    </script>
@endpush
