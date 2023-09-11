@extends('admin.layouts.master')

@section('title', 'invoices')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">invoices</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item active">invoices</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header d-flex align-items-center px-3" style="justify-content: space-between;">
                    <h3 class="card-title">invoice</h3>
                    <div class="row">
                        <a href="{{ route('admin.invoices.merger') }}" class="mx-2"><button type="button"
                            class="btn btn-outline-primary">Invoice Merger</button></a>
                        <a href="{{ route('admin.invoices.create') }}" class="mx-2"><button type="button"
                                class="btn btn-outline-primary">{{ __('Add Invoice') }}</button></a>
                        <a href="{{ route('admin.invoices.trashed') }}" class="mx-2"><button type="button"
                                class="btn btn-outline-primary"> Trashed
                                ({{ App\Models\Invoice::onlyTrashed()->count() }})</button></a>


                    </div>
                </div>




                <div class="px-3 mt-2"> <a href="{{ route('admin.invoices.excel') }}"><button type="button"
                            class="btn btn-primary">{{ __('Download Excel') }}</button></a>
                </div>
                <div class="card-body p-3">
                    <form class="frm-filter" action="{{ route('admin.invoices.index') }}" type="post" autocomplete="off">
                        @csrf

                        <div class="row">



                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Cycle</label>

                                    <select name="cycle" class="select2 form-select">
                                        <option value="0">Select</option>

                                        @foreach (\App\Enums\ECycle::asSelectArray() as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Transaction Status</label>

                                    <select name="t_status" class="select2 form-select">


                                        <option value="0">Unpaid
                                        </option>
                                        <option value="1">Paid
                                        </option>

                                    </select>
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
                                    <th>User</th>
                                    <th>Items</th>
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
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><a href="/admin/users?search={{ $item->user?->email }}"
                                                target="_blank">{{ $item->user?->email }}</a></td>
                                        <td>{{ $item->items()->count() }}</td>
                                        <td>{{ $item->price }}</td>
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
                                            @if ($item->transactions()->latest()->first()?->status == 1)
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
                                                <button type="submit"
                                                    onclick="swalConfirmDelete(this, title='Are you sure?', text='the related transaction could be deleted!')"
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
