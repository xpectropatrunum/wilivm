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
                            <div class="form-group col-lg-3">
                                <label>Make upgrade invoice?</label>
                                <div class="form-check">
                                    <input type="checkbox" name="upgrade" class="form-check-input" value="1">
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>

                        </div>
                    </div>

                 
                    <!-- /.card-body -->
                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>
                    </div>

                </form>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Invoices</h3>
            </div>
                <div class=" invoices">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Cycle</th>
                                    <th>{{ __('admin.created_date') }}</th>
                                    <th>Expires At</th>
                                    <th>Transaction Status</th>
                                    <th>Transaction Method</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->invoices()->latest()->get() as $item)
                                  
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><a href="/admin/users?search={{ $item->user?->email }}"
                                                target="_blank">{{ $item->user?->email }}</a></td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->cycle }} Months</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ date('Y-m-d H:i', $item->expires_at) }}</td>
                                        <td>


                                            @if ($item->transactions()->latest()->first()?->status == 1)
                                                <div class="badge badge-success">Paid</div>
                                            @else
                                                <div class="badge badge-warning">Unpaid</div>
                                            @endif

                                        </td>
                                        <td>
                                            @if ($item->transactions()->latest()->first()??->status == 1)
                                                {{ ucfirst($item->transactions()->latest()->first()?->method) }}
                                            @else
                                                -
                                            @endif

                                        </td>
                                        <td class="project-actions">
                                            <a href="{{ route('admin.invoices.edit', $item->id) }}">

                                                <button type="button" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                    Edit
                                                </button>
                                            </a>

                                            <form action="{{ route('admin.invoices.destroy', $item->id) }}"
                                                class="d-inline-block" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="swalConfirmDelete(this, title='Are you sure?', text='the related transaction could be deleted!')"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                    {{ __('admin.delete') }}
                                                </button>
                                            </form>


                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div></div>
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
                Swal.fire({html: "<span class='text-danger'>to confirm this action, click on `update` button again</span>",title: "Refund Request!",confirmButtonText:"got it!"})
                return false;

            }
            
        });
        function fetchProp() {
            type = $("[name=type]").val()
            plan = $("[name=plan]").val()
            $.get(`/admin/orders/props/${type}/${plan}`, function(res) {
                $("[name=os]").html(``)
                $("[name=location]").html(``)

                $("[name=cpu]").val(res.cpu)
                $("[name=ram]").val(res.ram)
                $("[name=bandwith]").val(res.bandwith)
                $("[name=storage]").val(res.storage)

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
