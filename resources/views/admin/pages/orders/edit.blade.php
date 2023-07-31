@extends('admin.layouts.master')

@section('title', 'Update order')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Order #{{ $order->id }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">List orders</a></li>
                <li class="breadcrumb-item active">Update order</li>
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
                    <h3 class="card-title">Update order</h3>
                </div>
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h4>User</h4>

                            </div>
                            <div class="form-group col-lg-4">
                                <label>Name</label>
                                <input type="text" value="{{ $order->user->first_name }} {{ $order->user->last_name }}"
                                    class="form-control" disabled>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Email</label>
                                <input type="text" value="{{ $order->user->email }}" class="form-control" disabled>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Registered Date</label>
                                <input type="text" value="{{ $order->user->created_at }}" class="form-control" disabled>
                            </div>

                            <div class="w-100"></div>
                            <div class="col-12 mb-3">
                                <h4>Transaction</h4>
                                @if ($order->transactions()->first()?->status == 1)
                                    Paid with
                                    <strong>{{ ucfirst($order->transactions()->latest()->first()?->method) }}</strong> at
                                    {{ $order->transactions()->latest()->first()?->updated_at }}<br>
                                    Tx id: <strong>{{ $order->transactions()->latest()->first()?->tx_id }}</strong>
                                @else
                                    Not paid
                                @endif


                            </div>

                            <div class="w-100"></div>
                            <div class="col-12 mb-3">
                                <h4>Server</h4>
                                Due Date: {{ MyHelper::due($order) }}<br>
                                Cycle: {{ App\Enums\ECycle::getKey($order->cycle) }}<br>
                                Created Date: {{ $order->created_at }}<br>


                            </div>


                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Type</label>

                                    <select name="type" class="select2 form-select">
                                        @foreach (\App\Models\ServerType::where('enabled', 1)->get() as $item)
                                            <option @if ($order->service->type == $item->name) selected @endif
                                                value="{{ $item->name }}">{{ $item->name }}
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
                                            <option @if ($order->service->plan == $item->name) selected @endif
                                                value="{{ $item->name }}">{{ $item->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Location</label>

                                    <select name="location" class="select2 form-select">
                                        <option value="{{ $order->service->location }}">
                                            {{ $order->service->location_->name }}
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Os</label>

                                    <select name="os" class="select2 form-select">
                                        <option value="{{ $order->service->os }}">{{ $order->service->os_->name }}
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Ram</label>
                                    <input class="form-control" name="ram" value="{{ $order->service->ram }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Cpu</label>
                                    <input class="form-control" name="cpu" value="{{ $order->service->cpu }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Storage</label>
                                    <input class="form-control" name="storage" value="{{ $order->service->storage }}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Bandwith</label>
                                    <input class="form-control" name="bandwith" value="{{ $order->service->bandwith }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Server IP</label>
                                    <input name="ip" class="form-control" value="{{ $order->service->ip }}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label> IPv4</label>
                                    <input name="ipv4" class="form-control" value="{{ $order->service->ipv4 }}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>IPv6</label>
                                    <input name="ipv6" class="form-control" value="{{ $order->service->ipv6 }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Server Username</label>
                                    <input name="username" class="form-control" value="{{ $order->service->username }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Server Password</label>
                                    <input name="password" class="form-control" value="{{ $order->service->password }}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Labels</label>

                                    <select name="label_ids[]" multiple class="select2 form-select">
                                        @foreach ($labels as $item)
                                            <option value="{{ $item->id }}"
                                                @if (in_array($item->id, json_decode($order->label_ids) ?? [])) selected @endif>{{ $item->name }}
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
                                            <option @if ($key == $order->service->status) selected @endif
                                                value="{{ $key }}">{{ $item }}
                                            </option>
                                        @endforeach


                                    </select>
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

                        </div>
                    </div>
                    <!-- /.card-body -->
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
        var confirm__ = 0;
        $("form").submit(function(e){
            if($("[name=status]").val() == 6 && confirm__ == 0){
                confirm__ = 1;
                Swal.fire({text: "to confirm this action, click on `update` button again",title: "Warning!"})
                return false;

            }
            
        });
        function fetchProp() {
            type = $("[name=type]").val()
            plan = $("[name=plan]").val()
            $.get(`/admin/orders/props/${type}/${plan}`, function(res) {
                $("[name=os]").html(``)
                $("[name=location]").html(``)

                $("[name=cpu]").vale(res.cpu)
                $("[name=ram]").vale(res.ram)
                $("[name=bandwith]").vale(res.bandwith)
                $("[name=storage]").vale(res.storage)

                res.os.map(item => {
                    if (item.id == {{ $order->service->os }}) {
                        $("[name=os]").append(`<option selected value="${item.id}">${item.name}</option>`)

                    } else {
                        $("[name=os]").append(`<option  value="${item.id}">${item.name}</option>`)

                    }
                })
                res.location.map(item => {
                    if (item.id == {{ $order->service->location }}) {
                        $("[name=location]").append(
                            `<option selected value="${item.id}">${item.name}</option>`)
                    } else {
                        $("[name=location]").append(`<option  value="${item.id}">${item.name}</option>`)
                    }
                })
            })
        }
    </script>
@endpush
