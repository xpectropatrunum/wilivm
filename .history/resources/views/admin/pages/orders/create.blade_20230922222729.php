@extends('admin.layouts.master')

@section('title', 'New order')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Order for {{ $user->first_name }} {{ $user->last_name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">List orders</a></li>
                <li class="breadcrumb-item active">New order</li>
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
                    <h3 class="card-title">Create order</h3>
                </div>
                <form action="{{ route('admin.orders.new', $user->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h4>User</h4>

                            </div>
                            <div class="form-group col-lg-4">
                                <label>Name</label>
                                <input type="text" value="{{ $user->first_name }} {{ $user->last_name }}"
                                    class="form-control" disabled>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Email</label>
                                <input type="text" value="{{ $user->email }}" class="form-control" disabled>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Registered Date</label>
                                <input type="text" value="{{ $user->created_at }}" class="form-control" disabled>
                            </div>






                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Type</label>

                                    <select name="type" class="select2 form-select">
                                        @foreach (\App\Models\ServerType::where('enabled', 1)->get() as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Plan</label>

                                    <select name="plan" class="select2 form-select">
                                        @foreach (\App\Models\ServerPlan::where('enabled', 1)->get() as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Location</label>

                                    <select name="location" class="select2 form-select">

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Os</label>

                                    <select name="os" class="select2 form-select">

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Billing Cycle</label>

                                    <select name="cycle" class="form-select select2">
                                        @foreach (config('admin.cycle') as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Ram</label>
                                    <input class="form-control" name="ram" value="{{ old('ram') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Cpu</label>
                                    <input class="form-control" name="cpu" value="{{ old('cpu') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Storage</label>
                                    <input class="form-control" name="storage" value="{{ old('storage') }}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Bandwith</label>
                                    <input class="form-control" name="bandwith" value="{{ old('bandwith') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Server IP</label>
                                    <input name="ip" class="form-control" value="{{ old('ip') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label> IPv4</label>
                                    <input name="ipv4" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label> IPv4 Secondary</label>
                                    <input name="ipv4_2" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>IPv6</label>
                                    <input name="ipv6" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Server Username</label>
                                    <input name="username" class="form-control" value="{{ old('username') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Server Password</label>
                                    <input name="password" class="form-control" value="{{ old('password') }}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Labels</label>

                                    <select name="label_ids[]" multiple class="select2 form-select">
                                        @foreach ($labels as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control form-select">
                                        @foreach (config('admin.user_service_status') as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}
                                            </option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input name="price" class="form-control" value="{{ old('price') }}">
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Is Linux?</label>
                                <div class="form-check">
                                    <input type="checkbox" name="linux" class="form-check-input" value="1">
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Inform user via email</label>
                                <div class="form-check">
                                    <input type="checkbox" name="inform" class="form-check-input" value="1">
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Make payment with user wallet</label>
                                <div class="form-check">
                                    <input type="checkbox" name="wallet" class="form-check-input" value="1">
                                    <label class="form-check-label" for="wallet"> Yes</label>
                                </div>
                            </div>



                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>

                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/simplebox/simplebox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script>
        $("[name=plan]").change(function() {
            fetchProp()
        });
        $("[name=type]").change(function() {
            fetchProp()
        });
        fetchProp()

        function fetchProp() {
            type = $("[name=type]").val()
            plan = $("[name=plan]").val()
            $.get(`/admin/orders/props/${type}/${plan}`, function(res) {

                $("[name=os]").html(``)
                $("[name=location]").html(``)


                if (res.success != 0) {
                    $("[name=cpu]").val(res.cpu)
                    $("[name=ram]").val(res.ram)
                    $("[name=bandwith]").val(res.bandwith)
                    $("[name=storage]").val(res.storage)

                    res.os.map(item => {

                        $("[name=os]").append(`<option  value="${item.id}">${item.name}</option>`)


                    })
                    res.location.map(item => {

                        $("[name=location]").append(`<option  value="${item.id}">${item.name}</option>`)

                    })
                }

            })
        }
    </script>
@endpush
