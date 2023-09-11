@extends('admin.layouts.master')

@section('title', 'payments')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">payments</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item active">payments</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>${{ App\Models\Wallet::sum('balance') }}</h3>
                            <p>All Wallets Balance</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-bitcoin"></i>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            @php
                                $paid_orders = App\Models\Order::with('transactions')
                                    ->get()
                                    ->filter(function ($q) {
                                        return $q
                                            ->transactions()
                                            ->latest()
                                            ->first()?->status ==
                                            1 and
                                            time() -
                                                strtotime(
                                                    $q
                                                        ->transactions()
                                                        ->latest()
                                                        ->first()->created_at,
                                                ) <
                                                30 * 86400;
                                    });
                            @endphp
                            <h3>${{ $paid_orders->sum('price') - $paid_orders->sum('discount') }}
                            </h3>
                            <p>1 Month Sale</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            @php
                                $paid_orders = App\Models\Order::with('transactions')
                                    ->get()
                                    ->filter(function ($q) {
                                        return $q
                                            ->transactions()
                                            ->latest()
                                            ->first()?->status ==
                                            1 and
                                            time() -
                                                strtotime(
                                                    $q
                                                        ->transactions()
                                                        ->latest()
                                                        ->first()->created_at,
                                                ) <
                                                3 * 30 * 86400;
                                    });
                            @endphp
                            <h3>${{ $paid_orders->sum('price') - $paid_orders->sum('discount') }}
                            </h3>
                            <p>3 Months Sale</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            @php
                                $paid_orders = App\Models\Order::with('transactions')
                                    ->get()
                                    ->filter(function ($q) {
                                        return $q
                                            ->transactions()
                                            ->latest()
                                            ->first()?->status ==
                                            1 and
                                            time() -
                                                strtotime(
                                                    $q
                                                        ->transactions()
                                                        ->latest()
                                                        ->first()->created_at,
                                                ) <
                                                6 * 30 * 86400;
                                    });
                            @endphp
                            <h3>${{ $paid_orders->sum('price') - $paid_orders->sum('discount') }}
                            </h3>
                            <p>6 Months Sale</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

            </div>



            <div class="card">
                <div class="card-header d-flex align-items-center px-3">
                    <h3 class="card-title">payments</h3>

                </div>

                <div class="px-3 mt-2"> <a href="{{ route('admin.payments.excel') }}"><button type="button"
                            class="btn btn-primary">{{ __('Download Excel') }}</button></a>
                </div>

                <div class="card-body p-3">

                    <form class="frm-filter" action="{{ route('admin.payments.index') }}" type="post" autocomplete="off">
                        @csrf

                        <div class="row">

                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Status</label>

                                    <select name="status" class="select2 form-select">

                                        <option @if ($status == -1) selected @endif value="-1">All
                                        </option>
                                        <option @if ($status == 0) selected @endif value="0">Unpaid
                                        </option>
                                        <option @if ($status == 1) selected @endif value="1">Paid
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Period</label>

                                    <select name="period" class="select2 form-select">


                                        <option @if ($period == 0) selected @endif value="0">All Time
                                        </option>
                                        <option @if ($period == 1) selected @endif value="1">Today
                                        </option>
                                        <option @if ($period == 2) selected @endif value="2">This Month
                                        </option>
                                        <option @if ($period == 3) selected @endif value="3">
                                            Custom
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">

                                <div class="date-box row" style="display: none">
                                    <div class="form-group col-lg-6">
                                        <label>From date time:</label>
                                        <input type="text" name="from_datetime" id="from-datetime" class="form-control "
                                            value="{{$from_datetime}}" required="">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label>To date time:</label>
                                        <input type="text" name="to_datetime" id="to-datetime" class="form-control "
                                            value="{{$to_datetime}}" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-5">
                                <a href="javascript:{}"><button type="submit" class="btn btn-info">Filter</button></a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>TX ID</th>
                                    <th>Order</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>{{ __('admin.created_date') }}</th>
                                    <th>Actions</th>



                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->tx_id }}</td>

                                        <td><a href="/admin/orders?search={{ $item->order_id }}"
                                                target="_blank">#{{ $item->order_id }}</a></td>

                                        <td>{{ $item->order?->price }}</td>
                                        <td>{{ $item->order?->discount }}</td>
                                        <td>{{ ucfirst($item->method) }}</td>
                                        <td>
                                            <a href="javascript:{}" class="status-menu" cs="{{ $item->id }}">
                                                @if ($item->status == 1)
                                                    <div class="badge badge-success">Paid</div>
                                                @elseif ($item->status == 0)
                                                    <div class="badge badge-warning">Unpaid</div>
                                                @elseif ($item->status == 2)
                                                    <div class="badge badge-danger">Refund</div>
                                                @elseif ($item->status == 3)
                                                    <div class="badge badge-danger">Fraud</div>
                                                @endif
                                            </a>

                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td class="project-actions">
                                            @if ($item->order)
                                                <a href="{{ route('admin.payments.edit', $item->id) }}">
                                                    <button type="button" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-pen"></i>
                                                        Edit
                                                    </button>
                                                </a>
                                            @endif

                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cart-footer p-3 d-block d-md-flex justify-content-between align-items-center border-top">
                    {{ $items->onEachSide(0)->links('admin.partials.pagination') }}

                    <p class="text-center mb-0">
                        {{ __('admin.display') . ' ' . $items->firstItem() . ' ' . __('admin.to') . ' ' . $items->lastItem() . ' ' . __('admin.from') . ' ' . $items->total() . ' ' . __('admin.rows') }}
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <textarea class="w-100 editor form-control" name="message" placeholder="Your message ..."></textarea>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" onclick="sendMail()" class="btn btn-primary">Send</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="statusModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Change Status</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="col-12">

                        <div class="form-group">
                            <label>Status</label>

                            <select name="status" class="form-select form-control ">

                                <option value="0">Unpaid</option>
                                <option value="1">Paid</option>
                                <option value="2">Refund</option>
                                <option value="3">Fraud</option>

                            </select>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" onclick="changeStatus()" class="btn btn-primary">Change</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.en.js') }}"></script>
    <script src="https://unpkg.com/ionicons@latest/dist/ionicons.js"></script>
    <script>
        var id_ = "";
        var id__ = "";

        function openModal(id) {
            id_ = id
            $("#myModal").modal("show")
        }
        $(".status-menu").click(function() {
            id__ = $(this).attr("cs")
            $("#statusModal").modal("show")
        })



        function changeStatus() {
            $.ajax({
                url: '/admin/payments/updateStatus/' + id__,
                type: 'post',
                data: {
                    'status': $("[name=status]").val(),
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(res) {
                    if (res == 1) {
                        Toast.fire({
                            icon: 'success',
                            'title': 'Changed successfully'
                        })
                        $("#myModal").modal("hide")
                    } else {
                        Toast.fire({
                            icon: 'error',
                            'title': 'Something went wrong'
                        })
                    }

                }
            });
        }

        function sendMail() {
            $.ajax({
                url: '/admin/sendmail/' + id_,
                type: 'post',
                data: {
                    'message': CKEDITOR.instances.message.getData(),
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(res) {
                    if (res == 1) {
                        Toast.fire({
                            icon: 'success',
                            'title': 'Message send successfully'
                        })
                        $("#myModal").modal("hide")
                    } else {
                        Toast.fire({
                            icon: 'error',
                            'title': 'Something went wrong'
                        })
                    }

                }
            });
        }
        $(function() {


            period = $('[name=period]').val()
            if (period == 3) {
                $(".date-box").show()
            } else {
                $(".date-box").hide()
            }


            $('[name=period]').change(function() {
                period = $(this).val()
                if (period == 3) {
                    $(".date-box").show()
                } else {
                    $(".date-box").hide()
                }
            });



            $('#from-datetime,#to-datetime').datepicker({
                language: 'en',
                timepicker: true,
                dateFormat: "yyyy-mm-dd",
                timeFormat: "hh:ii",
                autoClose: true
            });

            $('.changeStatus').on('change', function() {
                id = $(this).attr('data-id');

                if ($(this).is(':checked')) {
                    enable = 1;
                } else {
                    enable = 0;
                }

                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'post',
                    data: {
                        'enable': enable,
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
                        Toast.fire({
                            icon: 'success',
                            'title': 'Record status successfully changed'
                        })
                    }
                });
            });
        });
    </script>
@endpush
