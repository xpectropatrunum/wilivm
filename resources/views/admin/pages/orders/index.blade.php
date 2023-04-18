@extends('admin.layouts.master')

@section('title', 'orders')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">orders</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item active">orders</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header d-flex align-items-center px-3">
                    <h3 class="card-title">orders</h3>

                </div>

                <div class="px-3 mt-2"> <a href="{{ route('admin.orders.excel') }}"><button type="button"
                            class="btn btn-primary">{{ __('Download Excel') }}</button></a>
                </div>
                <div class="card-body p-3">
                    <form class="frm-filter" action="{{ route('admin.orders.index') }}" type="post" autocomplete="off">
                        @csrf

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="input-group input-group-sm" style="width: 70px;">
                                <select name="limit" class="custom-select">
                                    <option value="10" @if ($limit == 10) selected @endif>10</option>
                                    <option value="25" @if ($limit == 25) selected @endif>25</option>
                                    <option value="50" @if ($limit == 50) selected @endif>50</option>
                                    <option value="100" @if ($limit == 100) selected @endif>100</option>
                                    <option value="200" @if ($limit == 200) selected @endif>200</option>
                                </select>
                            </div>

                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="search" class="form-control"
                                    placeholder="{{ __('admin.search') }}..." value="{{ $search }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Plan</th>
                                    <th>Os</th>
                                    <th>Location</th>
                                    <th>Cycle</th>
                                    <th>{{ __('admin.created_date') }}</th>
                                    <th>Expires At</th>
                                    <th>Transaction Status</th>
                                    <th>Service Status</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                @php
                                if ($item->status == \App\Enums\EServiceType::Deploying) {
                                    $minutes_past = $item->order ? round((time() - strtotime($item->order->updated_at)) / 60) : 24 * 60;
                                    if ($minutes_past >= 24 * 60) {
                                        $item->status = \App\Enums\EServiceType::Cancelled;
                                        $item->save();
                                    }
                                }
                                @endphp
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><a href="/admin/users?search={{ $item->user?->email }}"
                                                target="_blank">{{ $item->user?->email }}</a></td>
                                        <td>{{ $item->service->type }}</td>
                                        <td>{{ $item->service->plan }}</td>
                                        <td>{{ $item->service->os_->name }}</td>
                                        <td>{{ $item->service->location_->name }}</td>
                                        <td>{{ $item->cycle }} Months</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ date('Y-m-d H:i', $item->expires_at) }}</td>
                                        <td>


                                            @if ($item->transactions()->latest()->first()->status == 1)
                                                <div class="badge badge-success">Paid</div>
                                            @else
                                                <div class="badge badge-warning">Unpaid</div>
                                            @endif

                                        </td>
                                        <td>


                                            @if ($item->service->status == 2)
                                                <span class="badge bg-success">Active</span>
                                            @elseif ($item->service->status == 5)
                                                <span class="badge bg-warning">Proccessing</span>
                                            @elseif ($item->service->status == 3)
                                                <span class="badge bg-danger">Expired</span>
                                            @elseif ($item->service->status == 4)
                                                <span class="badge bg-danger">Canceled</span>
                                            @else
                                                <span class="badge bg-warning">not set</span>
                                            @endif

                                        </td>
                                        <td class="project-actions">
                                            <a href="{{ route('admin.orders.edit', $item->id) }}">

                                                <button type="button" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                    Edit
                                                </button>
                                            </a>

                                            <form action="{{ route('admin.orders.destroy', $item->id) }}"
                                                class="d-inline-block" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="swalConfirmDelete(this)"
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
@endsection

@push('admin_css')
@endpush

@push('admin_js')
    <script>
        var id_ = "";

        function openModal(id) {
            id_ = id
            $("#myModal").modal("show")
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
