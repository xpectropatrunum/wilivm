@extends('admin.layouts.master')

@section('title', 'edit server')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">edit server</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.servers.index') }}">List servers</a></li>
                <li class="breadcrumb-item active">edit server</li>
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
                    <h3 class="card-title">edit server</h3>
                </div>
                <form action="{{ route('admin.servers.update', $server->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-lg-4">
                                <label>Type</label>
                                <select name="server_type_id" class="form-control select2">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            @if ($type->id == old('server_type_id', $server->server_type_id)) selected @endif>
                                            {{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-lg-4 ">
                                <label>Plan</label>
                                <select name="server_plan_id" class="form-control select2">
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}"
                                            @if ($plan->id == old('server_plan_id', $server->server_plan_id)) selected @endif>
                                            {{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-100"></div>
                            <div class="form-group col-lg-4 ">
                                <label>Available Operating systems</label>
                                <select name="os_ids[]" multiple class="form-control select2" required>
                                    @foreach ($os as $os_item)
                                        <option value="{{ $os_item->id }}"
                                            @if (in_array($os_item->id, old('os_ids', $server->os->pluck("id")->toArray()) ?? [])) selected @endif>
                                            {{ $os_item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-4 ">
                                <label>Available Locations</label>
                                <select name="location_ids[]" multiple class="form-control select2" required>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                            @if (in_array($location->id, old('location_ids', $server->locations->pluck("id")->toArray()) ?? [])) selected @endif>
                                            {{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-100"></div>
                            <div class="form-group col-lg-3">
                                <label>Ram</label>
                                <input type="text" value="{{ old('ram', $server->ram) }}" name="ram"
                                    placeholder="2GB" class="form-control @error('ram') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Cpu</label>
                                <input type="text" value="{{ old('cpu', $server->cpu) }}" name="cpu"
                                    placeholder="2 Core Intel Xeon" class="form-control @error('cpu') is-invalid @enderror"
                                    required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Storage</label>
                                <input type="text" value="{{ old('storage', $server->storage) }}" name="storage"
                                    placeholder="200GB SSD" class="form-control @error('storage') is-invalid @enderror"
                                    required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Bandwith</label>
                                <input type="text" value="{{ old('bandwith', $server->bandwith) }}" name="bandwith"
                                    placeholder="20GB" class="form-control @error('bandwith') is-invalid @enderror"
                                    required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Price</label>
                                <input type="text" value="{{ old('price', $server->price) }}" name="price"
                                    class="form-control @error('price') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>active</label>
                                <div class="form-check">
                                    <input type="checkbox" name="enabled" class="form-check-input" value="1"
                                        id="exampleCheck2" @if (old('enabled', $server->enabled)) checked @endif>
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
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
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.en.js') }}"></script>
@endpush
